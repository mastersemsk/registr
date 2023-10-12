<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Models\User;
use Content\Curl;
use \CURLFile;

class DiskController extends AppController {
	protected $name_service = 'ePOS Казахстан'; //имя приложения на  Яндекс.OAuth
	protected $clientid_yandex = '';
	protected $client_secret_yandex = '';
	protected $redirect_uri_yandex = 'https://oauth.yandex.ru/verification_code';//self::URL.'/panel/yandex_token'; // нужно добавить в настройки приложения на яндекс
	protected $clientid_google = '';
	protected $client_secret_google = '';
	protected $redirect_uri_google = self::URL.'/panel/google_token';
	protected $scope_google = '';//пример https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive.resource
	protected $login;
	protected $disk_token;
	protected $result = [];
	public $max_fail_size = 1000000;
	
	public function __construct() 
	{
		session_start();
		 $this->login = $_SESSION['login'];
		if (empty($this->login)) {
		   $this->redirect('/login');
		}
		$prov = USER::prov_email($this->login);
		if (empty($prov) || $prov[0]['token'] != $_SESSION['code']) {
			$this->redirect('/login');
		}
		$this->disk_token = $prov[0]['disk_token'];
	}
	
	public function index() 
	{
		//self::__construct();
		$this->result['token'] = $this->disk_token;
		//https://oauth.yandex.ru/authorize?response_type=token&client_id=2ba5ca2b7c8046a2b3936b1ae3600b6c
		if ($_GET['disk'] == 'yandex') {
			$this->redirect('https://oauth.yandex.ru/authorize?response_type=code&client_id='.$this->clientid_yandex.'&redirect_uri='.$this->redirect_uri_yandex);
		}
		elseif ($_GET['disk'] == 'google') {
			$this->redirect('https://accounts.google.com/o/oauth2/auth?client_id='.$this->clientid_google.'&redirect_uri='.$this->redirect_uri_google.'&response_type=code&scope='.$this->scope_google);
		}
		
		echo $this->twig()->render('/panel/integrations.twig',['result' => $this->result]);
	}
/*
запрашиваем токен для Яндекс
*/
	public function yandex_token()
	{
		if (isset($_GET['code']) && preg_match('/^[0-9]{7}$/',$_GET['code'])) {
			$options = [CURLOPT_URL => 'https://oauth.yandex.ru/token', CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => true,CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_RETURNTRANSFER => true,CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code='.$_GET['code'].'',CURLOPT_TIMEOUT => 8,
			CURLOPT_HTTPHEADER => ['Content-type: application/x-www-form-urlencoded','Accept: application/json','Authorization: Basic '.base64_encode($this->clientid_yandex.':'.$this->client_secret_yandex)],
		    ];
			$token = Curl::curl($options);
			if (isset($token['body'])) {
				$arr = json_decode($token['body'],true);
				if (isset($arr['access_token'])) {
					USER::disk_token($this->login,$arr['access_token']);
					$this->result['token'] = $arr['access_token'];
				}
				else { $this->result['error'] = $arr['error_description']; }
			}
			else {$this->result['error'] = 'Сервис Яndex не ответил!';}
		}
		else {$this->result['error'] = $_GET['error_description'] ?? 'Error Яndex'; }
		echo $this->twig()->render('/panel/res_token.twig',['result' => $this->result]);
	}
/*
запрашиваем токен для Google
*/
	public function google_token()
	{
		if (isset($_GET['code'])) {
			$params = [
			'client_id'     => $this->clientid_google,
			'client_secret' => $this->client_secret_google,
			'redirect_uri'  => $this->redirect_uri_google,
			'grant_type'    => 'authorization_code',
			'code'          => $_GET['code']
		    ];
			$options = [CURLOPT_URL => 'https://accounts.google.com/o/oauth2/token', CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => true,CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_RETURNTRANSFER => true,CURLOPT_POSTFIELDS => http_build_query($params),CURLOPT_TIMEOUT => 10,
			CURLOPT_HTTPHEADER => ['Content-type: application/x-www-form-urlencoded','Accept: application/json']
	        ];
			$token = Curl::curl($options);
			if (isset($token['body'])) {
				$arr = json_decode($token['body'],true);
				if (isset($arr['access_token'])) {
					USER::disk_token($this->login,$arr['access_token']);
					$this->result['token'] = $arr['access_token'];
				}
				else { $this->result['error'] = 'Google не может авторизовать одну или несколько запрошенных областей';}
			} 
			else {$this->result['error'] = 'Сервис Google не ответил!';}

		}
		else {$this->result['error'] = $_GET['error'] ?? 'Error Google'; }
		echo $this->twig()->render('/panel/res_token.twig',['result' => $this->result]);
	}
/*запись файла на Яндекс Диск*/
	public function userfail()
	{
		$this->result['token'] = $this->disk_token;
		if (!empty($_FILES)) {
			if ($_FILES['diskfile']['error'] == UPLOAD_ERR_OK) {
				if (!empty($_FILES['diskfile']['size']) && $_FILES['diskfile']['size'] < $this->max_fail_size) {
					$tmp_name = $_FILES['diskfile']['tmp_name'];
					$file_size = $_FILES['diskfile']['size'];
					$mim = mime_content_type($tmp_name);
					$name_fail = basename($_FILES['diskfile']['name']);
					$fp = fopen($tmp_name, 'r');
					if (isset($_POST['yandexfile'])) {
						$options = [CURLOPT_URL => 'https://cloud-api.yandex.net/v1/disk/resources/upload?path='.urlencode('app:/'.$name_fail).'&overwrite=true', 
						CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => true,CURLOPT_SSL_VERIFYHOST => 2,CURLOPT_RETURNTRANSFER => true,CURLOPT_TIMEOUT => 10,
						CURLOPT_HTTPHEADER => ['Accept: application/json','Authorization: OAuth '.$this->disk_token]
						];
						$res = Curl::curl($options);
						if (isset($res['body'])) {
							$arr = json_decode($res['body'],true);
							if (isset($arr['href'])) {
								
								$data = [CURLOPT_URL => $arr['href'],CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => true,CURLOPT_SSL_VERIFYHOST => 2,CURLOPT_RETURNTRANSFER => true,
								CURLOPT_UPLOAD => true,CURLOPT_PUT => true,CURLOPT_INFILE => $fp,CURLOPT_INFILESIZE => $file_size,CURLOPT_TIMEOUT => 20,
						         CURLOPT_HTTPHEADER => ['Accept: application/json']
						        ];
								$code = Curl::curl($data);
								if ($code['http_code'] == 201) {
									$this->result['error'] = 'Файл успешно загружен на Яndex.Диск';
								}
								else {$this->result['error'] = $code['http_code'];}
							}
							else {$this->result['error'] = $arr['description'] ?? 'Ошибка Яndex URL';}
						}
						else {$this->result['error'] = 'Сервис Яndex не ответил!'; }
						
					}
					elseif (isset($_POST['googlefile'])) {
						$cfile = new CURLFile($tmp_name,$mim,$name_fail);
						$data = [CURLOPT_URL => 'https://www.googleapis.com/upload/drive/v3/files?uploadType=media',CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => true,
						CURLOPT_SSL_VERIFYHOST => 2,CURLOPT_RETURNTRANSFER => true,CURLOPT_POST => true,CURLOPT_UPLOAD => true,CURLOPT_POSTFIELDS => ['cfile' => $cfile],CURLOPT_TIMEOUT => 20,
						CURLOPT_HTTPHEADER => ['Accept: application/json','Content-Type: '.$mim,'Content-Length: '.$file_size]
						];
						$res_google = Curl::curl($data);
						if ($res_google['http_code'] == 200) {
							$this->result['error'] = 'Файл успешно загружен на Google.Disk';
						}
						else {$this->result['error'] = $res_google['http_code'];}
					}
					else {$this->redirect('/login');}
				}
				else {$this->result['error'] = 'Большой размер файла'; }
				
			}
			else {$this->result['error'] = $_FILES['diskfile']['error']; }
		}
		echo $this->twig()->render('/panel/integrations.twig',['result' => $this->result]);
	}
}