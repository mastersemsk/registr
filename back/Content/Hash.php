<?php
namespace Content;

trait Hash
{   
	protected $alphabet = '0123456789_abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	public $size = 21; //длина строки
	protected $id;
	
	public function code()
	{
        
		session_start();
		while (1 <= self::$size--) {
		self::$id .= self::$alphabet[random_int(0,63)];
		}
        $_SESSION['code'] = self::$id;
		return $_SESSION['code'];
	}
	// проверка пароля
	public function verfPass(string $client_pass,string $baza_pass): bool
	{
		return password_verify($client_pass,$baza_pass);
	}
	//создание пароля
	public function creatPass(string $parol): string
	{
		return password_hash($parol,PASSWORD_DEFAULT);
	}
	// генерация пароля
    public function generate_password(int $symbolsCount): string|bool 
    {
      $arr = [
        ['a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z'],
        ['A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z'],
        ['1','2','3','4','5','6','7','8','9','0']
        ];
 
        $chars = array_map(function($group) {
        return $group[array_rand($group)];
        }, $arr);
 
        for($i = count($chars); $i < $symbolsCount; $i++) {
            $group = $arr[array_rand($arr)];
            $chars[] = $group[array_rand($group)];
        }
 
        shuffle($chars);
    
        return implode('', $chars);
    }
}