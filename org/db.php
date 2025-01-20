<?php
class FuncSQL {

private const HOST = 'localhost';
private const USER = 'root';
private const PASS = 'root';
private const DB = 'baza';

private static $db;
private $result;
	
public function __construct() {
	 error_reporting(0); mysqli_report(MYSQLI_REPORT_OFF);
	 if (!self::$db)
	 self::$db = new mysqli(self::HOST, self::USER, self::PASS, self::DB, 3306, null);
	   if (mysqli_connect_errno()) {
          throw new RuntimeException('ошибка соединения: ' . mysqli_connect_error());
        }
	 mysqli_set_charset(self::$db, "utf8mb4");
	}
public function QUERY($sql) {
	$result = null;
	$result = mysqli_query(self::$db, $sql) or die(mysqli_error(self::$db));
	return $this->result = $result;
    }
public function NumRows() {
	 $rows = mysqli_num_rows($this->result);
	 if(!isset($rows)) die();
	 return $rows;
	}
public function AffectRows() {
	 $rows = mysqli_affected_rows(self::$db);
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
	 return mysqli_insert_id(self::$db); //номер заказа
    }

public function FreeRes() {
    mysqli_free_result($this->result);
    }
public function Close() {	
	mysqli_close(self::$db);
	}
public function newTransaction() {
	 return mysqli_begin_transaction(self::$db); //начало транзакции
    }
public function closeСommit() {
	 return mysqli_commit(self::$db); //конец успешной транзакции
    }
public function closeRollback() {
	 return mysqli_rollback(self::$db); //возврат не успешной транзакции
    }
}