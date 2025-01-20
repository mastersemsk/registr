<?php
class FuncSQL1 extends mysqli {

protected $result;
	
public function __construct() {
	 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	 //parent::__construct($host=null, '', '', 'db', $port=null, '/tmp/mysql.sock');
	 parent::__construct('localhost', 'root', 'root', 'baza', '3306', $socket=null);
	 $this->set_charset("utf8");
	}
/*
Возвращает false в случае возникновения ошибки. В случае успешного выполнения запросов, 
которые создают набор результатов, таких как SELECT, SHOW, DESCRIBE или EXPLAIN, 
mysqli_query() вернёт объект mysqli_result. Для остальных успешных запросов mysqli_query() 
вернёт true.
*/
public function query($sql,$result_mode = MYSQLI_STORE_RESULT): bool|mysqli_result {
     $this->result = parent::query($sql,$result_mode = MYSQLI_STORE_RESULT) ?? null;
	 return $this->result;
    }
/*
Возвращает число строк, затронутых последним запросом SELECT
*/
public function NumRows(): int|string {
	 $rows = null;
	 if (isset($this->result)) {
	    $rows = $this->result->num_rows;
	 }
	 return $rows;
	}
/*
Возвращает число строк, затронутых последним запросом INSERT, UPDATE, REPLACE или DELETE
Целое число больше нуля указывает количество затронутых или извлечённых строк. 
Ноль означает, что записи для оператора UPDATE не обновлялись, 
ни одна строка не соответствовала выражению WHERE в запросе
 или что ни один запрос ещё не был выполнен. -1 означает, 
 что во время выполнения запроса произошла ошибка
*/
public function AffectRows(): int|string {
	 $rows = $this->affected_rows ?? null;
	 return $rows;
	}
/*
Выбирает одну строку данных из результирующего набора и возвращает её в виде массива, 
в котором индексы элементов соответствуют номерам столбцов (начиная с 0). 
Каждый последующий вызов функции будет возвращать массив с данными следующей строки набора
 или null, если строки закончились.
*/
public function FetchRow(): array|null|false {
	$rows = null;
	if (isset($this->result)) {
	     $rows = $this->result->fetch_row();
      }
	return $rows;
	}
/*
Выбирает одну строку данных из набора результатов и возвращает её в виде массива. 
Каждый последующий вызов этой функции будет возвращать следующую строку в наборе результатов
 или null, если строк больше нет.
 MYSQLI_ASSOC - ассоциативный массив
*/
public function ArrayRows(): array|null|false {
     $array = [];
	 if (isset($this->result)) {
	       while($rows = $this->result->fetch_array(MYSQLI_ASSOC))
		   {
		     $array[] = $rows;
		   }
       }
	 return $array;
    }
/*
Значение поля AUTO_INCREMENT, которое было затронуто предыдущим запросом. 
Возвращает ноль, если предыдущий запрос не затронул таблицы, содержащие поле AUTO_INCREMENT.
*/
public function Zakaz(): int|string {
	 return $this->insert_id;
    }
/*
Освобождает от результата запроса память, которая была зарезервирована
*/
public function FreeRes(): void {
     $this->result->free_result();
    }
public function Close(): void {	
	$this->close();
	}
public function newTransaction(): bool {
	 return $this->begin_transaction(); //начало транзакции
    }
public function closeСommit(): bool {
	 return $this->commit(); //конец успешной транзакции
    }
public function closeRollback(): bool {
	 return $this->rollback(); //возврат не успешной транзакции
    }
}
