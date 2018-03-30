<?php
session_start();
require_once 'app/autoloader.php';


if (isset($_POST['submitOrder'])) {
	header('Location: order.php');
  	    exit;
} else {

if (!isset($_POST['submitCart'])){ //корзина не отправлена

	//если список товаров пользователем не выбран
	if (!isset($_POST['cart'])) {
 	    echo "Товар не выбран!";
  	    header('Location: index.php');
  	    exit;

	} else {
		//список товаров пользователем выбран:
		//востанавливаем объекты-продукты из сессии
    	$item = $_SESSION['productList']; $_SESSION['productList'] = 0;
    	foreach ($_POST['cart'] as $key => $value) {
        	$productlist[] = unserialize($item[$value]);
       	}
    	//создаем объект-корзину с выбранными продуктами
    	$myCart = new classes\cart\Cart($_SESSION['userName'], $productlist);
    	//показываем форму с продуктами корзины
    	include 'cart1.php';
       	}
} else { //корзина отправлена -- пересчитываем корзину

	    //восстанавливаем корзину из сессии 
	    $myCart = unserialize($_SESSION['myCart']);
	    
	    //если изменено количество продуктов в корзине 
	    if (isset($_POST['number'])) {
	    	$number = ($_POST['number']);

	    	$myCart->setProductNumber($number);
	    	$myCart->getSum();
	    } 
	    //если запрос на удаление из корзины        
        if (isset($_POST['id'])) {
        	$id = $_POST['id'];
        	//удаляем выбранные товары из корзины
	        $myCart->deleteProduct($id);
	        $myCart->getSum();
	    }
	    //если в корзине что-то есть -- то обновляем список корзины пользователю
	    if (count($myCart->productList)) {
	    	include 'cart1.php';
	        } else { 
	        	die('<h2>Ваша корзина пуста!</h2><a href="index.php"> Вернуться к списку товаров </a>');
	        }
	    }
}
	   
	

?>