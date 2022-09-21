<?php
class WordCount{
  private $str;
  private $count;
  public function __construct($str){
    $this->str = $str;
    $this->count = str_word_count($str);
  }
  //truncate takes the number of words to return as its argument
  public function truncate($len){
    $arr = explode(" ",$this->str);
    $result = array();
    for($i=0;$i<$len;$i++){
      array_push($result,$arr[$i]);
    }
    return implode(" ",$result)."...";
  }
  public function getCount(){
    return $this->count;
  }
}
?>