<?php
	//получаем в массив $filelist список всех тестов в папке 
	$dir = getcwd() . '/tests/';
	$filelist = scandir($dir, 1);
	
	//получаем текущий $id файла теста для проверки
	if (!isset($_POST['test_id']))
	{	
		die("Данные не отправлены!<p><a href=\"list.php\">Выбрать другой тест</a></p>");
		
	} else {
		
		//получаем номер теста для проверки
		$id = htmlspecialchars(stripslashes($_POST['test_id']));
		
		//преобразуем строку $id в целое число
		$id = (intval($id));
	
		//читаем в массив содержимое файла теста, включая ответы
		$json = $dir . "$filelist[$id]";
		$test = json_decode(file_get_contents($json), true);
	
		//проверяем ответы пользователя
		if (isset($_POST['userAnswer']))
		{
			$userAnswer = $_POST['userAnswer'];
			
			if(count($userAnswer) === count($test))	
			{	
				$result = 0;
				foreach ($test as $key => $value)
				{	
					if ($value['correct'] == $userAnswer[$key])
					{
						$result++;
					}
					
				}
				echo "Ваш результат: $result правильных из " . count($userAnswer);
                    if ($result > 0) {
                        //получаем данные с именем и фамилией пользователя
                        $userName = strip_tags($_POST['userName']);
                       
                        //передаем в сертификат имя пользователя и его результат
                        echo "<p><a href=\"image/cert.php?userName=$userName&result=$result\">Скачать сертификат</a></p>";
                    } else {
                        echo "<p>Тест не пройден, пройдите заново!</p>";
                    }

			} else {
    			echo "Не все поля формы заполнены. Повторите ввод!";
    		}
    	} else {
    		echo "Введите ответы!";
    	}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Результаты теста</title>
</head>
<body>
<div>
<p><a href="list.php">Выбрать другой тест</a></p>
</div>
</body>
</html>