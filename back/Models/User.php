<?php
namespace Models;

class User extends Model
{

	/*
	 есть ли пользователь с таким email
	*/
	public static function prov_email($email) 
	{
		$result = Model::dbs("SELECT `name`,`verified`,`password`,`token`,`disk_token` FROM `usera` WHERE `email` = '".$email."' LIMIT 1");
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		return $rows;
	}
	/*
	 зписывает в базу юзера, выдаёт id
	*/
	public static function creat($arr_user)
	{
		return Model::dbin("INSERT INTO `usera` (`name`,`email`,`password`,`token`,`up_creat`) VALUES ('".$arr_user['imia']."','".$arr_user['login']."','".$arr_user['parol']."','".$arr_user['code']."','".date("Y-m-d H:i:s")."')");	
	}
	
	public static function auth_update($email,$code) 
	{
		return Model::dbs("UPDATE `usera` SET `token` = '".$code."',`up_creat` = '".date("Y-m-d H:i:s")."' WHERE `email` = '".$email."'");
	}
	
	public static function verifer_token($id) 
	{
		$result = Model::dbs("SELECT `token` FROM `usera` WHERE `id` = ".$id." AND `verified` = '0' LIMIT 1");
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		return $rows;
	}
	
	public static function up_token($id) 
	{
		return Model::dbs("UPDATE `usera` SET `verified` = '1' WHERE `id` = ".$id);
	}
	
	public static function up_pass($password,$email) 
	{
		return Model::dbs("UPDATE `usera` SET `password` = '".$password."' WHERE `email` = '".$email."'");
	}

	public static function disk_token($email,$code) 
	{
		return Model::dbs("UPDATE `usera` SET `disk_token` = '".$code."',`up_creat` = '".date("Y-m-d H:i:s")."' WHERE `email` = '".$email."'");
	}

}
