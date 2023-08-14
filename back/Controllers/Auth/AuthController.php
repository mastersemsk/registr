<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Controllers\Auth\PanelController;
use Content\Hash;
use Models\User;

class AuthController extends AppController 
{
	
	public function in($error=null,$oldemail=null) 
	{
		echo $this->twig()->render('/auth/login.twig',['error' => $error,'oldemail' => $oldemail,'code' => Hash::code()]); die();
	}
	
	public function prov() 
	{
		session_start();
		if (empty($_POST['code']) || $_SESSION['code'] != $_POST['code']) {
			http_response_code(429);
            die('429');
		}
		if (empty($_POST['login']) || filter_var($_POST['login'], FILTER_VALIDATE_EMAIL) === false) {
			$this->in('Ошибка ввода e-mail!');
		}
		
		if (empty($_POST['parol']) || preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $_POST['parol']) === 0) {
			
			$this->in('Пароль от 8 латинских символов, цифры, большие буквы и спец символы.',$_POST['login']);
		}
		
		$rows = User::prov_email($_POST['login']);
		if (empty($rows)) {
			$this->in('С таким email пользователя нет!',$_POST['login']);
		}
		
		if (empty(Hash::verfPass($_POST['parol'],$rows[0]['password']))) {
			$this->in('Неверный пароль!',$_POST['login']);
		}
		
		if (empty($rows[0]['verified'])) {
			$this->in('Вы не прошли проверку email! ',$_POST['login']);
		}
		
		$_SESSION['login'] = $_POST['login'];
		User::auth_update($_POST['login'],$_POST['code']);
		 
		 $this->redirect('/panel/requisites');
	}
	
	public function logout() 
	{
		session_start();
		User::auth_update($_SESSION['login'],'0');
		unset($_SESSION['code'],$_SESSION['login']);
		$this->redirect('/');
	}
}