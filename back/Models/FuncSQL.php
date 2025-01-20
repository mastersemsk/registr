<?php
namespace Models;

use mysqli;
use RuntimeException;

class FuncSQL {

private const HOST = 'localhost';
private const USER = 'root';
private const PASS = 'root';
private const DB = 'baza';

protected $db;
private $result;
	
public function __construct() {
	 error_reporting(0); mysqli_report(MYSQLI_REPORT_OFF);
	 if (!$this->db)
	 $this->db = new mysqli(self::HOST, self::USER, self::PASS, self::DB);
	   if (mysqli_connect_errno()) {
          throw new RuntimeException('ошибка соединения: ' . mysqli_connect_error());
        }
	 mysqli_set_charset($this->db, "utf8mb4");
	}
public function QUERY($sql) {
	$result = null;
	$result = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
	return $this->result = $result;
    }
public function NumRows() {
	 $rows = mysqli_num_rows($this->result);
	 if(!isset($rows)) die();
	 return $rows;
	}
public function AffectRows() {
	 $rows = mysqli_affected_rows($this->db);
	 if(!isset($rows)) die();
	  return $rows;
	}
public function FetchRow() {
	 $row = mysqli_fetch_row($this->result);
	 if(!isset($row)) die();
	  return $row;
	}
  
public function ArrayRows() {
     $array = [];
	 while($rows = mysqli_fetch_array($this->result,MYSQLI_ASSOC))
		{
		 $array[] = $rows;
		}
	 return $array;
    }
  
public function Zakaz() {
	 return mysqli_insert_id($this->db); //номер заказа
    }

public function FreeRes() {
    mysqli_free_result($this->result);
    }
public function Close() {	
	mysqli_close($this->db);
	}
public function newTransaction() {
	 return mysqli_begin_transaction($this->db); //начало транзакции
    }
public function closeСommit() {
	 return mysqli_commit($this->db); //конец успешной транзакции
    }
public function closeRollback() {
	 return mysqli_rollback($this->db); //возврат не успешной транзакции
    }
}