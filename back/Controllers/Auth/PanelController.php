<?php
namespace Controllers\Auth;

use Controllers\AppController;
use Models\User;

class PanelController extends AppController {
	
	use User;
	protected $login;
	
	public function __construct() 
	{
		session_start();
		 $this->login = $_SESSION['login'];
		if (empty($this->login)) {
		   $this->redirect('/login');
		}
		$prov = $this->prov_email($this->login);
		if (empty($prov) || $prov[0]['token'] != $_SESSION['code']) {
			$this->redirect('/login');
		}
	}
	
	public function requisites() 
	{
		//self::__construct();
		echo $this->twig()->render('/panel/index.twig');
	}
}