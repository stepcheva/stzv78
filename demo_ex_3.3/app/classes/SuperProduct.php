<?php
namespace classes;

abstract class SuperProduct
{    
  protected $title; 
  protected $price;
  protected $count;
  
  public function getTitle()
  {
    return $this->title;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function getCount()
  {
    return $this->count;
  }

  public function setCount($count)
  {
    $this->count = $count;
  }

  abstract function getDiscountPrice();
  abstract function getDeliveryPrice();
  abstract function getTotalPrice();
}