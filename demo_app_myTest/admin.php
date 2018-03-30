<?php
//если был выбран файл
if (isset($_FILES['userfile']['name']))
{   
	//если файл загружен без ошибок
	$error = $_FILES['userfile']['error'];
	if (!$error) {
		
		//проверяем загружаемый файл на корректость его типа (json)

		//.........................................................
		$name = basename($_FILES['userfile']['name']);
		
		//"вырезаем" расширение файла из полного имени
		$type = strtolower(substr($name, 1 + strrpos($name,".")));
		$extentions = "json";
		//проверяем расширение файла
		if ($type != $extentions) {

			//сообщаем пользователю об ошибочном формате файла
			echo "Файл имеет недопустимое расширение!";

		} else {
			
			//................................................
			$uploaddir = getcwd() . '/tests/' . $name;

			//проверяем наличие одноименного файла на сервере
			if (file_exists($uploaddir)) {

		    	echo "Файл $name уже существует. Выберите другой файл!</br>";

			} else {

		    	//перемещаем файл из временной директории в постоянное место
				$tmp_name = $_FILES['userfile']['tmp_name'];
				//............................................
        		move_uploaded_file($tmp_name, $uploaddir);
        		echo "Файл $name успешно отправлен!</br>";
        	}
		}
	} elseif (empty(($_FILES['userfile']['name']))) {
		
		echo "Файл не выбран!\n";
	
	} else {
		
		echo "Ошибка загрузки файла!\n";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Загрузить файл теста</title>
	<meta charset="utf-8">
</head>
<body>
<div>
<form enctype="multipart/form-data" action="admin.php" method="POST">
	<fieldset>
	    <legend><strong>Выберите файл для загрузки:</strong></legend>
    	<input name="userfile" type="file" placeholder="Выбрать файл с тестом:" />
    	<button type="submit" value="Отправить файл">Отправить файл</button>
	</fieldset>
    <p><a href="list.php">Перейти к списку доступных тестов</a></p>
</form>
</div>
</body>
</html>



