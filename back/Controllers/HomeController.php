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
    public function test()
    {
      $arr = ['title' => 'Сотовые операторы', 'descrip' => 'Список мобильных операторов для оплаты на нашем сервисе',
    'keywords' => 'оплатить сотовую связь, оплата мобильного онлайн', 'canonical' => self::URL.'/sota'];
      echo $this->twig()->render('list.twig',['arr' => $arr, 'code' => $this->code,'login' => $this->login]);
    }


}
