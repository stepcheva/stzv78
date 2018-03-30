<?php
namespace classes\weels;

use \classes\Product;
use \classes\GetInfoProduct;

class Weels extends Product implements GetInfoProduct
{
  private $size; 
 
  public function __construct($title, $size, $price, $count) 
  { 
    $this->title = $title;
    $this->price = $price;
    $this->size = $size;
    $this->setCount($count);
  }

  public function getInfoProduct()
  { 
    $info = "<p>" . $this->title . "</br> 
    Размер: " . $this->size . "</p>";
    return $info;
  }
}