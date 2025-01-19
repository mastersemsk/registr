<?php
namespace Models;

use mysqli;
use RuntimeException;
trait Connect
{
    protected $li;
    public function __construct()
    {
        if(!isset($this->li)) {
            error_reporting(0);
            mysqli_report(MYSQLI_REPORT_OFF);
            $mysqli = new mysqli('localhost', 'root', 'root', 'baza');
            if ($mysqli->connect_errno) {
                throw new RuntimeException('ошибка соединения');
            }
            $mysqli->set_charset('utf8mb4');
            if ($mysqli->errno) {
                throw new RuntimeException('ошибка запроса');
            }
            $this->li = $mysqli;
        }
        
    }
}
