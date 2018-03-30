<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'DataBase.php';
require_once 'DataBaseAPI.php';


$objDb = new DataBaseAPI;
$action = "";

$order  = ($action == 'order') ?  $order : "date_added";
$list = $objDb->selectAllDataAPI($order);
echo "<pre>";
print_r($list);
echo "</pre>";
?>
