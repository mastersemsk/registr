<?php
require 'pay.php';
$array = getKurs();
 
header('Content-Type: application/json');
echo json_encode($array, JSON_UNESCAPED_UNICODE);
