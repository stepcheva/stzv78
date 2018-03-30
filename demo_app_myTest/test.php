<?php
	//получаем в массив $filelist список всех тестов в папке 
	$dir = getcwd() . '/tests/';
	$filelist = scandir($dir, 1);
	
	//получаем текущий $id файла теста для отображения в форме
	if (isset($_GET['test_id']) && (is_numeric($_GET['test_id'])))
	{
		$id = htmlspecialchars(stripslashes($_GET['test_id'])) - 1;
	} 
	else 
	{
		die("<a href=\"list.php\">Выбрать тест</a>");
	}
	
	$id = (intval($id));
	
	if ($id <= (count($filelist)-3))
	{
		//читаем в массив содержимое файла теста
		$json = $dir . "$filelist[$id]";
		$test = json_decode(file_get_contents($json), true);
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Окно прохождения теста</title>
	<style type="text/css">
	div {
   		background: #fff; /* Цвет фона */
    	color: #000; /* Цвет текста */
    	padding: 15px; /* Поля вокруг текста */
        margin-top: 15px; /* Отступ сверху */
    }
    li {
    	list-style-type: none;
    }
  
	</style>

</head>
<body>
<form action="result.php" method="post">
<div>
<fieldset>
    <legend><h3>Тест <?php echo $filelist[$id]?></h3></legend>
	<input name="test_id" type="hidden" value="<?php echo $id ?>">
	<?php
	foreach ($test as $key => $value) 
	{	
		echo "<strong> $key. ". $value['textQwestion'] . "</strong>";
		foreach ($value['answer'] as $k => $val) 
		{
			echo  "<li><input type=\"radio\" name=\"userAnswer[" . $key . "]\" value=\"" . $k . "\" required>$val</li>";
		}
	}
	?>
	<input name="userName" type="text" size="50" value="" placeholder="Введите Ваше имя и фамилию" autocomplete="on">
	<input type="submit" value="Отправить">
<p><a href="list.php">Выбрать другой тест</a></p>
</div>
</form>
</body>
</html>