<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Models\User;
use Content\PHPMailer\SendMail;
use Content\Hash;

class PasswordResetController extends AppController
{
	public function form_pass ($error=null,$oldemail=null)
	{
		echo $this->twig()->render('/auth/forgot_password.twig',['error' => $error,'oldemail' => $oldemail,'code' => Hash::code()]); die();
	}
}