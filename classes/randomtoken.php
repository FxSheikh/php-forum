<?php
class RandomToken{
  private $token;
  public function __construct($length=16){
    $this->token = bin2hex(openssl_random_pseudo_bytes($length));
    $this->returnToken();
  }
  private function returnToken(){
    return $this->token;
  }
  public function __toString(){
    return $this->token;
  }
}
?>