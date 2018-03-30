<?php
session_start();
require_once 'DataBase.php';

$objDb = DataBase::getDB();
$action = "";

if (isset($_POST['addTask'])) {
	$action = (isset($_POST['addTask'])) ? 'addTask': "";
	$description = (isset($_POST['addTask'])) ? strip_tags(htmlspecialchars($_POST['description'])) : "";
} elseif (isset($_GET['action'])) {
	$action = (isset($_GET['action'])) ? strip_tags(htmlspecialchars($_GET['action'])) : "";
	$id = intval($_GET['id']);
	$description = strip_tags(htmlspecialchars($_GET['description']));
} elseif(isset($_POST['order'])) {
	$action = (isset($_POST['order'])) ? 'order' : "";
	$order = strip_tags(htmlspecialchars($_POST['order_by']));
} elseif (isset($_POST['change'])) {
	$action = (isset($_POST['change'])) ? 'change' : "";
	$description = strip_tags(htmlspecialchars($_POST['description']));
	$id = intval($_POST['id']);
}

switch ($action) {
    case 'addTask':
        //добавляем задачу 
        if (!ctype_space($description)){
            $objDb->insertData($description);
        } else {
            echo "<p style='color: red;'>Некорретный ввод!</p>";
        }
        break;
    case 'change':
        //изменяем задачу
        $objDb->editData($id, $description);
        break;
    case 'done':
        //отмечаем задачу
        $objDb->markData($id);
        break;
    case 'delete':
        //удаляем задачу
        $objDb->deleteData($id);
        break;
    default:
        echo 'Действие не указано!';
}

$order  = ($action == 'order') ?  $order : "date_added";
$task = $objDb->selectAllData($order);

require_once 'tmpl.php';

?>
