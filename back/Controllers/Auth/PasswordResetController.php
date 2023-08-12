<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Models\User;
use Content\PHPMailer\SendMail;

class PasswordResetController extends AppController
{
	public function form_pass ($error=null,$oldemail=null)
	{
		echo $this->twig()->render('/auth/forgot_password.twig',['error' => $error,'oldemail' => $oldemail,'code' => $this->sescode(21)]); die();
	}
}