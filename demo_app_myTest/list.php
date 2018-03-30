<?php

$dir = getcwd() . '/tests/';
$filelist = scandir($dir, 1);

//если в папке есть файлы с тестами, то выводим их нумерованным списком
function getList($filelist)
{   
    if (!$filelist) 
        {
            echo "<h3>Тесты не найдены!</h3>";
        } else {
            echo "<h3>Список тестов:</h3><ol>";
            for ($i = 0; $i < (count($filelist)-2); $i++)
                {   
                    echo '<li>' . $filelist[$i] . '</li>';
                 };
            echo "</ol>"; 
        }
}

//формируем код для вывода выпадающего списка с тестами
function getTest($filelist)
{   
    for ($i = 0; $i < (count($filelist) - 2); $i++)
        {   
            $id = $i+1;
            echo "<option value=\"$id\">" . $filelist[$i] . "</option>";
        };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список тестов</title>
</head>
<body>
<div>
<?php getList($filelist)?>
<form action="test.php" method="get">
    <fieldset>
        <legend>Выберите тест для загрузки:</legend>
        <select name="test_id">
        <?php getTest($filelist) ?>
        </select>
       <input type="submit" value="Отправить">
    </fieldset>
</form>
<p><a href="admin.php">Загрузить новый тест</a></p>
</div>
</body>
</html>
