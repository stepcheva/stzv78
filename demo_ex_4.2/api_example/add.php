<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");

require_once 'DataBase.php';
require_once 'DataBaseAPI.php';

$objDb = new DataBaseAPI;
$action = "";

$data = ['description' => 'Сходить в музей'];

if ($objDb->insertData($data['description']))
	echo "Объект создан";
else
	echo "Ошибка вставки данных";
?>
