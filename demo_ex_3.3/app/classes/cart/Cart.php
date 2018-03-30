<?php
namespace classes\cart;
use \classes\Product;
use \classes\GetInfoProduct;

class Cart
{ 
    public $userName; //имя пользователя, работающего с корзиной
    public $productList; //массив для хранения объектов-продуктов
    public $productNumber; //массив количества выбранных продуктов
    public $sum = 0;
  
    public function __construct($userName, $products) {
        $this->userName = $userName;
        foreach ($products as $value) {
            $this->productList[] = $value;
            $this->productNumber[] = 1; //по умолчанию корзина создается с кол-вом продуктов по одному
            $this->sum += $value->getTotalPrice();
        }
         
    }

    public function setProductNumber($number) {
    	foreach ($number as $key => $value) {
            if ($value !== '')
                $this->productNumber[$key] = intval($value);
            }
    }


    public function deleteProduct($id) {
    	foreach ($id as $key => $value){
                $id = intval($value);
    			unset($this->productList[$id]);
                unset($this->productNumber[$id]);
    		}
            $this->getSum();
    } 
    public function getSum() {
        $summa = 0;
    	foreach ($this->productList as $key => $value) {
           $summa += $value->getTotalPrice()*$this->productNumber[$key];
        }
        $this->sum = $summa;
}
   } 
 

