<?php
namespace classes\food;
use \classes\Product;
use \classes\GetInfoProduct;

class Food extends Product implements GetInfoProduct
{
  protected $countryFrom;
  private $weight;
  
  public function __construct($title, $countryFrom, $price, $weight, $count) 
  { 
    $this->title = $title;
    $this->countryFrom = $countryFrom;
    $this->price = $price;
    $this->weight = $weight; //вес в кг
    $this->setDiscount();
    $this->setCount($count);
  }

  public function getInfoProduct()
  { 
    $info = "<p>" . $this->title . "</br>  
    Производитель: " . $this->countryFrom . "</br>Вес партии (кг):  " . $this->weight . "</p>";
    return $info;
  }

  public function setDiscount()
  { 
    if ($this->weight <= 10) 
      return $this->discount = 0;
  }
  
  public function getDiscountPrice() 
  { 
    if ($this->weight > 10) //скидку считаем если вес > 10 кг 
    {
      return parent::getDiscountPrice();
    } else return $this->price;
  } 

}