<?php
require 'db.php';
class OrgApi {
	private const TOKEN = 'wb7jxInR5m01N';
	private const DISTANCE = 0.5; //растояние на котором искать организации, км
	private const RADIUS_EARTH = 6378;  // радиус земли, km
	private $db;
	
	public function __construct($token) {
		$this->token($token);
		$this->db = new FuncSQL();	
	}
	
	/*				SELECT `organizations`.`name`,`organizations`.`phones`,
		`buildings`.`address`,`activities`.`activitie`
		FROM `organizations`,`buildings`,`activities`,`organizations_activities` 
		WHERE `organizations`.`buildings_id` = `buildings`.`id`
		AND `activities`.`id` = ".$activ

		SELECT `organizations`.`name`,`organizations`.`phones`,`activities`.`activitie` 
		FROM `organizations`
		LEFT JOIN `organizations_activities` 
		ON `organizations_activities`.`organizations_id` = `organizations`.`id`
		LEFT JOIN `activities` 
		ON `organizations_activities`.`activities_id` = `activities`.`id`

		SELECT `activities`.`activitie` as `activities_activitie`,
		`activities_up`.`activitie` as `activities_up_activitie`
		FROM `activities` 
		LEFT JOIN `activities` as `activities_up` 
		ON `activities_up`.`id` = `activities`.`activities_id` 
		WHERE `activities_up`.`id` = ".$activ." OR `activities`.`id` = ".$activ

	 список всех организаций, которые относятся к указанному виду деятельности
	*/
	public function list_org_activ(int $activ) {
		$this->db->QUERY("SELECT `organizations`.`name`,`organizations`.`phones`,`activities`.`activitie` 
		FROM `organizations`
		LEFT JOIN `organizations_activities` 
		ON `organizations_activities`.`organizations_id` = `organizations`.`id`
		LEFT JOIN `activities` 
		ON  `activities`.`id` = `organizations_activities`.`activities_id`
		WHERE `activities`.`activities_id` = ".$activ." OR `activities`.`id` = ".$activ);
		$arr = $this->db->ArrayRows();
		return $this->in_json($arr);
	}

	/* 
	список организаций, которые находятся в заданном радиусе/прямоугольной области 
	относительно указанной точки на карте. список зданий
	*/
	public function list_org_radius(string $address) {
		$name = trim(strip_tags(stripcslashes(htmlspecialchars($address))));
		$this->db->QUERY("SELECT `lat`,`lng` FROM `buildings` WHERE `address` LIKE '%".$name."%' LIMIT 1");
		$arr = $this->db->ArrayRows();
		
		$lat = $arr[0]['lat']; //широта организации
		$lng = $arr[0]['lng']; //долгота 

		//расчёт ограничения широты и долготы в градусах 
		//rad2deg из радианов в градусы
		
		$max_latitude = $lat + rad2deg(self::DISTANCE/self::RADIUS_EARTH);
		
		$min_latitude = $lat - rad2deg(self::DISTANCE/self::RADIUS_EARTH);
		
		// deg2rad Преобразовывает значение из градусов в радианы
		
		$max_longitude = $lng + rad2deg(self::DISTANCE/self::RADIUS_EARTH/cos(deg2rad($lat)));
		
		$min_longitude = $lng - rad2deg(self::DISTANCE/self::RADIUS_EARTH/cos(deg2rad($lat)));
	//ищем в таблице buildings организации в диапазоне коорлинат
		$this->db->QUERY("SELECT `organizations`.`name`,`organizations`.`phones`,
		`buildings`.`address` FROM `buildings` LEFT JOIN `organizations` 
		ON `organizations`.`buildings_id` = `buildings`.`id` 
		WHERE `buildings`.`lat` > ".$min_latitude." AND `buildings`.`lat` < ".$max_latitude." 
		AND `buildings`.`lng` > ".$min_longitude." AND `buildings`.`lng` < ".$max_longitude." LIMIT 10");
		$arr_address = $this->db->ArrayRows();
		$this->in_json($arr_address);
	}
	/*
	список всех организаций находящихся в конкретном здании
	*/
	public function list_org_build(string $build) {
		$name = trim(strip_tags(stripcslashes(htmlspecialchars($build))));
		$this->db->QUERY("SELECT `organizations`.`name`,`organizations`.`phones`,`buildings`.`address` 
		FROM `organizations`,`buildings` WHERE `organizations`.`buildings_id` = `buildings`.`id` AND `buildings`.`address` LIKE '%".$name."%' LIMIT 10");
		$arr = $this->db->ArrayRows();
		$this->in_json($arr);
	}
	/*
	вывод информации об организации по её идентификатору
	*/
	public function id_org(int $id) {
		$this->db->QUERY("SELECT `organizations`.`name`,`organizations`.`phones`,`buildings`.`address`		
		FROM `organizations`,`buildings` WHERE `buildings`.`id` = `organizations`.`buildings_id` AND `organizations`.`id` = ".$id);
		$arr = $this->db->ArrayRows();
		return $this->in_json($arr);
	}
	/*
	поиск организации по названию
	*/
	public function org_name(string $org_name) {
		$name = trim(strip_tags(stripcslashes(htmlspecialchars($org_name))));
		$this->db->QUERY("SELECT `organizations`.`name`,`organizations`.`phones`,`buildings`.`address` 
		FROM `organizations`,`buildings` WHERE `buildings`.`id` = `organizations`.`buildings_id` AND `organizations`.`name` LIKE '%".$name."%' LIMIT 10");
		$arr = $this->db->ArrayRows();
		$this->in_json($arr);
	}
	//проверка токена
	private function token(string $token): string {
		if (self::TOKEN !== $token) {
			$this->in_json(['error' => 'Error token']);
		}
		return true;
	}
	//ответ в json
	private function in_json(array $arr): string {
		header('Content-Type: application/json');
		if (empty($arr)) $arr = ['error' => 'Не найдено'];
		echo json_encode($arr,JSON_UNESCAPED_UNICODE);
		die();
	}
}