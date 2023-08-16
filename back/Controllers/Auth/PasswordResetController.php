<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Models\User;
use Content\PHPMailer\SendMail;
use Content\Hash;

class PasswordResetController extends AppController
{
	public function form_pass($error=null,$oldemail=null)
	{
		echo $this->twig()->render('/auth/forgot_password.twig',['error' => $error,'code' => Hash::code()]); die();
	}
	
	public function send_pass()
	{
		if (empty($_POST['login']) || filter_var($_POST['login'], FILTER_VALIDATE_EMAIL) === false) {
			$this->form_pass('������ ����� e-mail!');
		}
		
		$prov = User::prov_email($_POST['login']);
		if (empty($prov)) {
			$this->form_pass('������������ � ����� email �� ���������������!');
		}
		
		if (empty($prov[0]['verified'])) {
			$this->form_pass('��� email �� ����������!');
		}
		 $new_pass = Hash::generate_password(10);
		 $new_pass_hazh = Hash::creatPass($new_pass);
		 User::up_pass($new_pass_hazh,$_POST['login'])
		$send = new SendMail;
		$text_pisma = '������������, <b>'.$prov[0]['name'].'</b>. <br>������� �� ����������� �� ����� �������. �� ��������� ��������� ������. 
		��� ��� ����� ������ '.$new_pass;
		$zagolovok = '�������������� ������ WMsemsk';
		$otvet = $send->send($_POST['login'],$text_pisma,$zagolovok,$prov[0]['name']);
		if (!empty($otvet)) {
			$this->form_pass('�� ��������� ������ �� '.$_POST['login'].'. '.$otvet);
		}
		
		$this->form_pass($prov[0]['name'].', ��� ��������� ����� ������, �� ����� '.$_POST['login'].'!');
	}
}