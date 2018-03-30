<?php
namespace classes;

use classes\SuperProduct;

class Product extends SuperProduct
{ 
  
  protected $discount = 10;
  protected $delivery = 250;

  public function getDiscount()
  {
    return $this->discount;
  }
    
  public function getDiscountPrice() //считаем цену со скидкой
  {  
    if ($this->discount) {
      return $this->price - round($this->price * $this->discount / 100);
    } else return $this->price;
  }

  public function getDeliveryPrice() //считаем стоимость доставки
  {
    if($this->discount)//если была скидка
    {
      $this->delivery = 300;
    } 
    return $this->delivery;
  }

  public function getTotalPrice() 
  {
      return $this->getDiscountPrice() + $this->getDeliveryPrice();
  }
}