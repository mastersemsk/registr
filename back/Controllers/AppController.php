<?php
namespace Controllers;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


class AppController
{
	const NAME = 'EPOS';
	const URL = 'http://e-pos/';
	public function twig () 
	{
	
	$loader = new FilesystemLoader(__DIR__ . '/../../temp');
    $twig = new Environment($loader, [
        'cache' => __DIR__ . '/../../temp/cashe',
        'auto_reload' => true,
    ]);
	return $twig;
	}
	
	public function redirect($put) 
	{
		header('Location: '.$put); die();
	}
}