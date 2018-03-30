<?php
require_once 'DataBase.php';
require_once 'DataBaseAPI.php';

$objDb = new DataBaseAPI;
$action = "";

$description = isset($_POST['description']) ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS) : '';

if (!isset($_POST['description']))
	echo "Ошибка передачи данных";
else {

	if ($objDb->insertData($description))
	    echo "Объект создан";
    else
	    echo "Ошибка вставки данных";
}
	
?>
