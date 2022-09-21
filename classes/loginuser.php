<?php
class LoginUser{
  private $database;
  private $session;
  public $login_error;
  
  public function __construct(){
    $this->session = new SessionManager();
    $this->database = new DataStorage();
  }
      
  public function Login($username, $password){  
    
    $login_query = "SELECT * FROM users WHERE user_name='$username'";
    $result = $this->database->runSelectQuery($login_query); 
    $number_rows = $this->database->numRows($login_query); 
    
    if($number_rows>0){
      $userid = $result[0]["user_id"];
      $useremail = $result[0]["user_email"];
      $hashed = $result[0]["user_password"];
      $username = $result[0]["user_name"];
      $userlevel = $result[0]["user_level"];
    }
    
    if(!password_verify($password,$hashed)) {
        // create error since password does not match
        $this->login_error = "The login details don't match our records";
        return false;
    } 
    else {
        // password matches
        $this->login_error = "";
        
        // create session variables          
        $this->session->setVars(array("user_id"=>$userid,"user_email"=>$useremail,"user_name"=>"$username"));
        
        if($userlevel==1){
             $this->session->setVars(array("admin_id"=>"admin"));
        }
        return true;
    }
  }         
        
}
  
?>
