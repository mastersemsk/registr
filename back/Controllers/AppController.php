<?php
namespace Controllers;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


class AppController
{
	private $alphabet = '0123456789_abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	private $id;
	
	private function code ($size) : string
	{
        while (1 <= $size--) {
		$this->id .= $this->alphabet[random_int(0,63)];
		}
		return $this->id;
	}
	
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
	
	public function sescode($size=21) 
	{
		session_start();
		$_SESSION['code'] = $this->code($size);
		return $_SESSION['code'];
	}

}