<?php
session_start();
$_SESSION['userName'] = 'admin';

require_once 'app/autoloader.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Список товаров</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<form  action='cart.php' method='POST'>
    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <tr class="danger">
                <th>Наименование товара</th>
                <th>Цена, руб.</th>
                <th>Скидка, % </th>
                <th>Цена со скидкой, руб.</th>
                <th>Стоимость доставки, руб.</th>
                <th>Итоговая стоимость, руб.</th>
                <th>В корзину</th>
            </tr>
        </thead>
        <tbody>
        <?php  
        $list[] = new classes\tech\Tech('Телевизор нового поколения', 30000, 'LG', 5);
        $list[] = new classes\tech\Tech('Стиральная машина', 12600, 'LG1250', 8);
        $list[] = new classes\weels\Weels('Резина летняя Dunlop SP Winter Sport 400','175/70 R13', 1930, 6);
        $list[] = new classes\weels\Weels('Резина летняя Kumho Ecowing ES01 KH27','165/60 R14', 2330, 4);
        $list[] = new classes\weels\Weels('Резина летняя Tigar Sigura','165/60 R14', 2420, 6);
        $list[] = new classes\food\Food('Огурцы','Россия', 120, 4, 25);
        $list[] = new classes\food\Food('Киви','Египет', 140, 15, 60);

        foreach ($list as $key => $value) {
            $item[] = serialize($value);
            echo "<tr>
            <td>" . $value->getInfoProduct() . "</td>
            <td>" . $value->getPrice() . "</td>
            <td>" . $value->getDiscount() . "</td>
            <td>" . $value->getDiscountPrice() . "</td>
            <td>" . $value->getDeliveryPrice() . "</td>
            <td>" . $value->getTotalPrice() . "</td>";
            echo '<td><input type="checkbox" name="cart[]" value=' . $key . '></td></tr>';
        }
        
        $_SESSION['productList'] = $item;
        ?>

    </tbody>
    </table>
    <input type="submit" class="btn btn-primary" value="Перейти в корзину">
    <input type="reset" class="btn btn-default" value="Очистить форму">
</form>
</div>
</body>
</html>
