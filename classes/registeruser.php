<?php
class RegisterUser{
  private $database;
  private $session;
  
  public function __construct(){
    $this->session = new SessionManager();
    $this->database = new DataStorage();

  }
      
  public function isEmailExist($emailid){  
    $emailQuery = "SELECT * FROM users WHERE user_email = '".$emailid."'";
    $numberOfRows = $this->database->numRows($emailQuery);
    
    // if the number of rows is greater than 1 then the email does exist    
    if($numberOfRows > 0){  
      return true;  
    }  
  }  

  public function isUserExist($userid){  
    $userQuery = "SELECT * FROM users WHERE user_name = '".$userid."'";
    $numberOfRows = $this->database->numRows($userQuery);
 
    // if the number of rows is greater than 1 then the username does exist    
    if($numberOfRows > 0){  
      return true;  
    }
  }
        
  public function userRegister($username, $useremail, $password, $country){  
    $hashed_password = password_hash($password,PASSWORD_DEFAULT);

    $register_query = 
    "INSERT INTO users (user_name, user_password,user_email,user_register_date,user_country,user_level,active) 
    values('$username','$hashed_password','$useremail',NOW(),'$country',0,1)"; 
  
    return $this->database->runInsertQuery($register_query);  
  
  }       

  public function registerLogin($useremail){
    $login_query = "SELECT * FROM users WHERE user_email='$useremail'";
    $result = $this->database->runSelectQuery($login_query); 
    // $number_rows = $this->database->numRows($login_query); 
    
    // if($number_rows>0){
    $userid = $result[0]["user_id"];
    $username = $result[0]["user_name"];   
    $useremail = $result[0]["user_email"];
    // }
    
    // create session variables
    $this->session->setVars(array("user_id"=>$userid,"user_email"=>$useremail,"user_name"=>"$username"));
  }
  
  
  // public function createUserSession($userid,$username,$useremail){
  //   $vars = array();
  //   if($userid){$vars["user_id"] = $userid;}
  //   if($username){$vars["user_name"] = $username;}
  //   if($useremail){$vars["user_email"] = $useremail;}
  
  //   $this->session->setVars($vars);
  // }        
        
}
  
?>
