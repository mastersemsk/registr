<?php
namespace Models;

trait User
{
	use Connect;

	/*
	 есть ли пользователь с таким email
	*/
	public function prov_email($email) 
	{
		$result = $this->li->query("SELECT `name`,`verified`,`password`,`token`,`disk_token` FROM `usera` WHERE `email` = '".$email."' LIMIT 1");
		return $result->fetch_assoc();
	}
	/*
	 зписывает в базу юзера, выдаёт id
	*/
	public function creat($arr_user)
	{
		$this->li->query("INSERT INTO `usera` (`name`,`email`,`password`,`token`,`up_creat`) VALUES ('".$arr_user['imia']."','".$arr_user['login']."','".$arr_user['parol']."','".$arr_user['code']."','".date("Y-m-d H:i:s")."')");
		return $this->li->insert_id;
	}
	
	public function auth_update($email,$code) 
	{
		return $this->li->query("UPDATE `usera` SET `token` = '".$code."',`up_creat` = '".date("Y-m-d H:i:s")."' WHERE `email` = '".$email."'");
	}
	
	public function verifer_token($id) 
	{
		$result = $this->li->query("SELECT `token` FROM `usera` WHERE `id` = ".$id." AND `verified` = '0' LIMIT 1");
		return $result->fetch_assoc();;
	}
	
	public function up_token($id) 
	{
		return $this->li->query("UPDATE `usera` SET `verified` = '1' WHERE `id` = ".$id);
	}
	
	public function up_pass($password,$email) 
	{
		return $this->li->query("UPDATE `usera` SET `password` = '".$password."' WHERE `email` = '".$email."'");
	}

	public function disk_token($email,$code) 
	{
		return $this->li->query("UPDATE `usera` SET `disk_token` = '".$code."',`up_creat` = '".date("Y-m-d H:i:s")."' WHERE `email` = '".$email."'");
	}

}
