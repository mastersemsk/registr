<?php
namespace Models;

class User extends Model
{
    protected static $pass;
	
    public static function auth($email,$password) 
	{
		$result = Model::dbs("SELECT `password` FROM `usera` WHERE `email` = '".$email."' LIMIT 1");
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		if (!empty($rows)) {
		    self::$pass = password_verify($password, $rows[0]['password']);
		}
		return self::$pass;
	}
	/*
	 есть ли пользователь с таким email
	*/
	public static function prov_email($email) 
	{
		$result = Model::dbs("SELECT `verified`,`token` FROM `usera` WHERE `email` = '".$email."' LIMIT 1");
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		return $rows;
	}
	/*
	 зписывает в базу юзера, выдаёт id
	*/
	public static function creat($arr_user)
	{
		$id = Model::dbin("INSERT INTO `usera` (`name`,`email`,`password`,`token`,`up_creat`) VALUES ('".$arr_user['imia']."','".$arr_user['login']."','".$arr_user['parol']."','".$arr_user['code']."','".date("Y-m-d H:i:s")."')");	
		return $id;
	}
	
	public static function auth_update($email,$code) 
	{
		$result = Model::dbs("UPDATE `usera` SET `token` = '".$code."',`up_creat` = '".date("Y-m-d H:i:s")."' WHERE `email` = '".$email."'");
		return $result;
	}
	
	public static function verifer_token($id) 
	{
		$result = Model::dbs("SELECT `token` FROM `usera` WHERE `id` = ".$id." AND `verified` = '0' LIMIT 1");
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		return $rows;
	}
	
	public static function up_token($id) 
	{
		$result = Model::dbs("UPDATE `usera` SET `verified` = '1' WHERE `id` = ".$id);
		return $result;
	}
}
