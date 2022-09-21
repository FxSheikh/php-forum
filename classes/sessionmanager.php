<?php
class SessionManager{
  private $id;
  private $sessionstarttime;
  public function __construct(){
    //if session has not started, start a new session
    $now = date("Y-m-d H:i:s");
    if(!session_id() ) {
      // session_start();
      $id = session_id();      
      //add session time
      if(!$this->getVars("time")){
        $this->setVars(array("time"=>$now));
        //check session id
        $this->setVars(array("id"=>$id));
      }
    }
    else{
      //if session has started, get its attributes
      // session_start();
      $this->id = session_id();
    }
    // session_start();
    // print_r($_SESSION)s;
  }
  public function getSessionId(){
    return $this->id;
  }
  public function regenerate(){
    session_regenerate_id(new RandomToken());
    $this->id = session_id();
  }
  public function setVars($arr){
    foreach($arr as $key=>$value){
      $_SESSION[$key] = $value;
    }
  }
  public function getVars($name){
    if($_SESSION[$name]){
      return $_SESSION[$name];
    }
    else{
      return false;
    }
  }
  public function deleteVars($arr){
    foreach($arr as $sessionvar){
      unset($_SESSION[$sessionvar]);
      if(!$_SESSION[$sessionvar]){
        return true;
      }
      else{
        return false;
      }
    }
  }
  public function destroy(){
    session_destroy();
    session_regenerate_id();
  }
}
?>