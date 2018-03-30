<!DOCTYPE html>
<html>
<head>
    <title>Корзина</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<div>
  <h2><?php echo "В Вашей корзине " . count($myCart->productList) . " поз. на сумму ". $myCart->sum . " рублей"; ?></h2>
  <form  action='cart.php' method='POST'>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="danger">
                <th>Наименование товара</th>
                <th>Количество, шт/кг</th>
                <th>Изменить количество</th>
                <th>Стоимость, руб.</th>
                <th>Удалить из корзины</th>
            </tr>
        </thead>
        <tbody>
        <?php  
        foreach ($myCart->productList as $key => $value) {
            //получаем кол-во продукта, доступное для заказа
        	$max = $value->getCount();
        	echo "<tr>
            <td>" . $value->getInfoProduct() . "</td>
            <td>" . $myCart->productNumber[$key] . "</td>";
            echo '<td><input type="number" name="number['. $key . ']" min="1" max="' . $max . 'value="" placeholder="Количество">
            <p>Доступно для заказа (шт/кг) -- '. $max  . '</p></td>';
            echo "<td>" . $value->getTotalPrice()*$myCart->productNumber[$key]. "</td>";
            echo '<td><input type="checkbox" name="id['. $key . ']" value=' . $key . '></td></tr>';
        }
        $_SESSION['myCart'] = serialize($myCart);
        ?>
    </tbody>
    </table>
    <input type="submit" name="submitCart" class="btn btn-primary" value="Пересчитать корзину">
    <input type="submit" name="submitOrder" class="btn btn-default" value="Оформить заказ">
</form>
</div>
</body>
</html>