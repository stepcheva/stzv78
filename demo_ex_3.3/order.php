<?php
session_start();
require_once 'app/autoloader.php';


$myCart = unserialize($_SESSION['myCart']);

$name = $_SESSION['userName'];
$addr = '432027, Ульяновск, Деева 24-43';
$summa = $myCart->sum;

foreach ($myCart->productList as $key => $value) {
	$content[] = array($value->getInfoProduct(), $myCart->productNumber[$key], $value->getTotalPrice()*$myCart->productNumber[$key]); 
   }

$myOrder = new classes\order\Order($name, $addr, $summa, $content);
$myOrder->printOrder();

session_destroy();
echo '<a href="index.php"> Вернуться к списку товаров </a>';
?>

