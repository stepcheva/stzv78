<!DOCTYPE html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
   <title>Мой список дел</title>   
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-8 col-sm-offset-4 col-md-offset-2">

<h2>Приложение "ToDo"</h2>

<div class="panel panel-primary">
    <div class="panel-heading">Список дел на сегодня</div>
    
    <div class="panel-body">

    <?php if ($action === 'edit'): ?>
    
        <form method="POST" action="index.php">
        <div class="form-group">
            <input class="field" type="text" name="description" value="<?php echo $description;?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="change" value="Изменить задачу">
        </div>
        </form>
    
    <?php else: ?>
    
        <form method="POST" action="index.php">
        <div class="form-group">
            <input class="field" type="text" name="description" placeholder="Описание задачи" value="" required>
            <input type="submit" name="addTask" value="Добавить задачу">
        </div>
        </form>
   
        <form method="POST" action="index.php">
            <div class="form-group">
            <label for="order">Сортировать по:</label>
            <select class="form" name="order_by">
                <option value="date_added">Дате добавления</option>
                <option value="is_done">Статусу</option>
                <option value="description">Описанию</option>
            </select>
            <input type="submit" name="order" value="Отсортировать">
            </div>
        </form>
   
    <?php endif; ?>

    <div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Описание задачи</th>
                <th>Дата добавления</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            <?php foreach ($task as $key => $value): ?>
                <tr>
                    <td><?php echo htmlspecialchars($value['description'], ENT_QUOTES); ?></td>
                    <td><?php echo $value['date_added']; ?></td>
                    <?php if ($value['is_done'] == true): ?>
                        <td style='color: green;'>Выполнено</td>
                    <?php else: ?>
                        <td style='color: red;'>Не выполнено</td>
                    <?php endif; ?>
                    <td>
                        <a href="?id=<?php echo $value['id']; ?>&description=<?php echo $value['description']; ?>&action=edit">Изменить</a>
                        <a href="?id=<?php echo $value['id']; ?>&action=done">Выполнить</a>
                        <a href="?id=<?php echo $value['id']; ?>&action=delete">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>