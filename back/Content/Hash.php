<?php
namespace Content;

class Hash
{   
	protected static $alphabet = '0123456789_abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	public static $size = 21; //длина строки
	protected static $id;
	
	public static function code()
	{
        
		session_start();
		while (1 <= self::$size--) {
		self::$id .= self::$alphabet[random_int(0,63)];
		}
        $_SESSION['code'] = self::$id;
		return $_SESSION['code'];
	}
	// проверка пароля
	public static function verfPass($client_pass,$baza_pass)
	{
		return password_verify($client_pass,$baza_pass);
	}
	//создание пароля
	public static function creatPass($parol)
	{
		return password_hash($parol,PASSWORD_DEFAULT);
	}
}