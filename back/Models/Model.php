<?php
namespace Models;

use MySQLi;

class Model {
const USER = 'root';
const PASS = 'root';
const BAZA = 'laravel';
const BAZA_URL = 'localhost';
	
	public static function dbs ($data) {
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli(self::BAZA_URL, self::USER, self::PASS, self::BAZA,3306);
	$mysqli->set_charset("utf8");
    $result = $mysqli->query($data);
    $mysqli->close();
	return $result;
	}
	/*
	 Запись в базу с выводом номера AUTO_INCREMENT
	*/
	public static function dbin ($data) {
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli(self::BAZA_URL, self::USER, self::PASS, self::BAZA,3306);
	$mysqli->set_charset("utf8");
    $mysqli->query($data);
	$result = $mysqli->insert_id;
    $mysqli->close();
	return $result;
	}
}