<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");

require_once 'DataBase.php';
require_once 'DataBaseAPI.php';

$objDb = new DataBaseAPI;

$data = ['id' => '11'];

if ($objDb->deleteData($data['id']))
	echo "Объект удален";
else
	echo "Ошибка удаления данных";
?>
