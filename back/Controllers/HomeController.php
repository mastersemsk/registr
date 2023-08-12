<?php
namespace Controllers;

class HomeController extends AppController
{
   protected $login;
   protected $code;
	
	/**
     * Главная страница
     */
    public function index()
    {   session_start();
	    if (isset($_SESSION['login'])) $this->login = $_SESSION['login'];
		if (isset($_SESSION['code'])) $this->code = $_SESSION['code'];
		echo $this->twig()->render('index.twig',['code' => $this->code,'login' => $this->login]);
    }
}
