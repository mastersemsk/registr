<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Models\User;
use Content\PHPMailer\SendMail;
use Content\Hash;

class RegisterController extends AppController 
{
	protected $id;
	
	public function reg($error=null,$oldemail=null)
    {
        echo $this->twig()->render('/auth/reg.twig',['error' => $error,'oldemail' => $oldemail,'code' => Hash::code()]); die();
    }
	
	/*
	 Проверяем данные регитсрации пользователя
	*/
	public function prov() 
	{
		session_start();
		if (empty($_POST['code']) || $_SESSION['code'] != $_POST['code']) {
			http_response_code(429);
            die('429');
		}
		/*
		   Проверка имени пользователя
		*/
		if (empty($_POST['imia']) || preg_match('/^[0-9a-zа-яё]{4,25}$/iu', $_POST['imia']) == 0) {
			$this->reg('Неверное Имя!');
		}
		if (empty($_POST['login']) || filter_var($_POST['login'], FILTER_VALIDATE_EMAIL) === false) {
			$this->reg('Ошибка ввода e-mail!');
		}
		
		if (empty($_POST['parol']) || preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $_POST['parol']) === 0) {
			
			$this->reg('Пароль от 8 латинских символов, цифры, большие буквы и спец символы.',$_POST['login']);
		}
		
		if (empty($_POST['parol1']) || $_POST['parol'] !== $_POST['parol1']) {
			$this->reg('Пароли не совпадают.',$_POST['login']);
		}
		
		if (!empty(User::prov_email($_POST['login']))) {
			$this->reg('Пользователь с таким email уже зарегистрирован!',$_POST['login']);
		}
	    /* 
		  Записываем в базу
		*/
		$this->id = User::creat(['code' => $_POST['code'],'imia' => $_POST['imia'],'login' => $_POST['login'],'parol' => Hash::creatPass($_POST['parol'])]);
		if (empty($this->id)) {
		    $this->reg('Ошибка записи!');
	    }
		
		$send = new SendMail;
		$text_pisma = 'Здравствуйте, <b>'.$_POST['imia'].'</b>. <br>Спасибо за регистрацию на нашем сервисе. Вам нужно перейти по 
		ссылке <a href="http://e-pos/register/'.$this->id.'/'.$_POST['code'].'">Активировать</a>, для подтверждения.';
		$zagolovok = 'Активация WMsemsk';
		$otvet = $send->send($_POST['login'],$text_pisma,$zagolovok,$_POST['imia']);
		if (!empty($otvet)) {
			$this->reg('Ваша учётная запись возможно не будет активирована. Мы отправили письмо на '.$_POST['login'].'. '.$otvet);
		}
		$this->redirect('/');
	}
	
	public function prov_email($id,$token) {
		//http://e-pos/register/3/HX9yVbNVtICf8qSaIwQ-q
		$res_token = User::verifer_token($id);
		if (empty($res_token) || empty($token) || mb_strlen($token,'UTF-8') != Hash::$size) {
			 $this->reg('Регистрации не существует или вы уже активировали ссылку');
		}
		if (empty($res_token[0]['token']) || $res_token[0]['token'] !== $token) {
			$this->reg('Регистрации не существует');
		}
		User::up_token($id);
		$this->redirect('/');
	}
}