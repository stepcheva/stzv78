<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once 'DataBase.php';
require_once 'DataBaseAPI.php';

$objDb = new DataBaseAPI;

$id = isset($_GET['id']) ? $_GET['id'] : die('Объект не существует');

print_r($objDb->selectOneAPI($id));

?>
