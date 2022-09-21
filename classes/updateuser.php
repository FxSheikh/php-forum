<?php
class UpdateUser{
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

  public function updateUser($userid, $username, $useremail, $password, $country){  
    $hashed_password = password_hash($password,PASSWORD_DEFAULT);

    $update_query = 
    "UPDATE users SET user_name='$username', user_email='$useremail', user_password='$hashed_password', 
    user_country='$country' where user_id=$userid";
  
    
    return $this->database->runUpdateQuery($update_query);  
  
  }  
        
  public function returnCountry($userid){
    $country_query = "SELECT user_country FROM users WHERE user_id=$userid";
    $result = $this->database->runSelectQuery($country_query); 
    $country = $result[0]["user_country"];
    
    return $country;

  }
  
  
}
  
?>
