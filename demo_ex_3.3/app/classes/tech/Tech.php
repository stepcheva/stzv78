<?php
namespace classes\tech;

use \classes\Product;
use \classes\GetInfoProduct;

class Tech extends Product implements GetInfoProduct
{ 
  private $model; 
  
  public function __construct($title, $price, $model, $count) 
  { 
    $this->title = $title;
    $this->price = $price;
    $this->model = $model; 
    $this->setCount($count);
  }

  public function getInfoProduct()
  { 
    $info = "<p>" . $this->title . "</br> 
    Модель: " . $this->model . "</p>";
    return $info;
  }

}