<?php
class Navigation{
  private $navigation_items = array();
  private $session;
  private $database;
  private $query = "SELECT * FROM pages";
  public function __construct(){
    $this->session = new SessionManager();
    $this->database = new DataStorage();
    if(!$this->session->getVars("user_id")){
      $this->query = $this->query." "."WHERE login=0";
      // echo "USER NOT LOGGED IN";
    }
    if($this->session->getVars("user_id") && !$this->session->getVars("admin_id")){
      $this->query = $this->query." ".
      "WHERE (login=0 OR login=1) AND hidewhenloggedin=0 AND admin=0";
      // echo "NOT ADMIN BUT LOGGED IN !! = 0";
    }
    if($this->session->getVars("user_id") && $this->session->getVars("admin_id")){
      $this->query = $this->query." ".
      "WHERE (login=1 OR login=0) AND hidewhenloggedin=0";
      // echo "LOGGED IN AND ADMIN !!";
    }
    // echo $this->query;
    $this->query = $this->query." "."ORDER BY show_order ASC";
    $this->getNavItems();
  }
  private function getNavItems(){
   // echo $this->query
    $result = $this->database->runSelectQuery($this->query);
    if(count($result)>0){
      $this->navigation_items = $result;
      return $this->navigation_items;
    }
    else {
      return false;
    }
  }
  public function getNavigation(){
    return $this->navigation_items;
  }
  
  public function getJSON(){
    return json_encode($this->navigation_items);
  }
}
?>