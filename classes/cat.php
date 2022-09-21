<?php
class Cat{
  // public properties are visible from other classes
  public $legs;
  public $hastail;
  // private properties are only visible within the particular instance of the class
  private $haswhiskers;
  //__ construct() has to be public and creates an object based on the class
  public function __construct(){
    $this->legs = 4;
    $this->hastail = true;
    $this->haswhiskers = true;
  }
  // functions in a class are called methods
  public function miaow(){
    return "miawing....";
  }
}
?>
