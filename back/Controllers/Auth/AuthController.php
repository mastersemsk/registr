<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Content\Hash;
use Content\Validation;
use Models\User;

class AuthController extends AppController 
{
	
	use User,Validation,Hash;
	public function in($error=null,$oldemail=null) 
	{
		echo $this->twig()->render('/auth/login.twig',['error' => $error,'oldemail' => $oldemail,'code' => $this->code()]); die();
	}
	
	public function prov() 
	{
		session_start();
		if (empty($_POST['code']) || $_SESSION['code'] != $_POST['code']) {
			http_response_code(429);
            die('429');
		}
		if (empty($this->isEmail($_POST['login']))) {
			$this->in('Ошибка ввода e-mail!');
		}
		
		if (empty($this->isStr($_POST['parol'],'/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/'))) {
			
			$this->in('Пароль от 8 латинских символов, цифры, большие буквы и спец символы.',$_POST['login']);
		}
		
		$rows = $this->prov_email($_POST['login']);
		if (empty($rows)) {
			$this->in('С таким email пользователя нет!',$_POST['login']);
		}
		
		if (empty($this->verfPass($_POST['parol'],$rows[0]['password']))) {
			$this->in('Неверный пароль!',$_POST['login']);
		}
		
		if (empty($rows[0]['verified'])) {
			$this->in('Вы не прошли проверку email! ',$_POST['login']);
		}
		
		$_SESSION['login'] = $_POST['login'];
		$this->auth_update($_POST['login'],$_POST['code']);
		 
		 $this->redirect('/panel/requisites');
	}
	
	public function logout() 
	{
		session_start();
		$this->auth_update($_SESSION['login'],'0');
		unset($_SESSION['code'],$_SESSION['login']);
		$this->redirect('/');
	}
}