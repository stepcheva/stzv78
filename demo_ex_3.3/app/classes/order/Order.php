<?php
namespace classes\order;

class Order
{ 
	public static $id = 0;
	public $userName;
	public $date;
	public $address;
	public $sum;
	public $content;
	public $status;

	public function __construct($userName, $address, $sum, $content) {
		self :: $id++;
		$this->userName = $userName;
		$this->date = date('F j, Y, g:i a');
		$this->address = $address;
		$this->sum = $sum;
		$this->status = 'new';
		$this->content = $content;
	}

	public function printOrder() {
		echo "<h2>Заказ №" . self :: $id . " от " . $this->date . "</h2></br>";
		echo "Состав заказа:";
		echo "<table border = '1'>";
		foreach ($this->content as $key => $value) {
			echo "<tr><td>" . $value[0] . "</td><td>" . $value[1] . " </td><td>" . $value[2]. " руб. </td></tr>";
		}
		echo "</table>";
		echo "<h4>Сумма заказа: " . $this->sum . " рублей</h4>";
		echo "<h4>Адрес доставки: " . $this->address . "</h4>";
	}
}
?>