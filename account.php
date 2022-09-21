<?php
session_start();
include_once("autoloader.php");
$page_title = "Account Profile Page";
$update_user = new UpdateUser();     

$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];
$user_id = $_SESSION["user_id"];

// print_r($_SESSION);

$initial_country = $update_user->returnCountry($user_id);

// var_dump($initial_country);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    $useremail = $_POST["email-profile"];
    $username = $_POST["username-profile"];
    $country = $_POST["country"];
    $initial_country = $_POST["country"];
    $password = $_POST["password-profile"];
    $password_confirm = $_POST["password_confirm-profile"];
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $user_email = $_SESSION["user_email"];
    
    // array of errors
    $errors = array();
    $password_confirm_error = array();
    
    // validate email address
    if(!filter_var($useremail,FILTER_VALIDATE_EMAIL)){
        $errors["email"] = "Email address is invalid";
    }
    
    // check the username length
    if(strlen($username) < 6 || strlen($username)>30){
        $errors["username"] = "Username needs to be more than 6 characters and less than 30 characters";
    }
    
    // remove spaces from username
    $nospace = str_replace(" ","",$username);
    
    // check if alphanumeric
    if(!ctype_alnum($nospace)){
        $errors["username"] = $errors["username"]." "."Only A-Z,a-z,0-9 allowed";
    }
    
    // check password length
    if(strlen($password)<8){
      $errors["password"] = "Password should be a minimum of 8 characters";
    }
    
    // check password_confirm length
    if(strlen($password_confirm)<8){
      array_push($password_confirm_error,"Password should be a minimum of 8 characters");
    }    
    
    //if passwords are not equal log errors
    if($password!==$password_confirm){
      array_push($password_confirm_error,"Passwords are not the same");
      $errors["password_confirm"] = implode(" and ",$password_confirm_error);   
    }

    //if there are no errors then proceed with the update of the user
    if(count($errors)==0){
        
        // sanitize the input values except password, because the password gets hashed
        $sanitized_user_email = filter_var($useremail,FILTER_SANITIZE_EMAIL);
        $sanitized_user_name = filter_var($username,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);        

        // check if the username already exists
        $user_exists = $update_user->isUserExist($sanitized_user_name);
        if($user_exists && $sanitized_user_name !== $user_name){
            // the username already exists in the database
            $errors["username"] = "This username already exists";
        }

        // check if the email already exists
        $email_exists = $update_user->isEmailExist($sanitized_user_email);

        if($email_exists && $sanitized_user_email !== $user_email){
            // the email already exists in the database
            $errors["email"] = "This email already exists";
        } 
        
        if(count($errors)==0){
            
            // if there are no errors we need to update the user
           $update = $update_user->updateUser($user_id,$sanitized_user_name,$sanitized_user_email,$password,$country);
           
            if(!$update){
                echo "Could not update account account profile";
            } 
            else {
                //--------- account updated successfully
                $profile_message = "Account profile updated";
                // need to update session information
                $_SESSION["user_name"] = $sanitized_user_name;
                $_SESSION["user_email"] = $sanitized_user_email;
                
            }   
        }
        
    } 
}
?>

<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="profile-background">
        <div class="wrapper">
        <?php include_once("includes/pagenavigation.php"); ?>
        <div class="container">
            <div class="row">
                <h1 id="prof-h1"class="col-md-12 text-center">Update Profile</h1>
                <hr>
                <div class="col-md-4 col-md-offset-4">
                    <form id="profile-form" method="post" action="">
                       
                        <?php 
                            if($errors["username"]){ $usernameerror = "has-error"; }
                            if($errors["email"]){ $emailerror = "has-error"; }
                            if($errors["password"]){$pwerror = "has-error"; }
                                else{$pwerror = "has-success"; }
                            if($errors["password_confirm"]){$pwconfirmerror = "has-error"; }
                                else{$pwconfirmerror = "has-success"; }
                        ?>
                        
                        <div class="form-group <?php echo $usernameerror; ?>">
                            <label for="username-profile">Username</label>
                            <input type="text" class="form-control profile-input-background" name="username-profile" id="username-profile" required placeholder="Username"
                            <?php echo "value=$user_name";?>>
                            <span class="help-block">
                                <?php echo $errors["username"]; ?>
                            </span>
                        </div>                        
                        
                        <div class="form-group <?php echo $emailerror; ?>">
                            <label for="email-profile">Email</label>
                            <input type="email" class="form-control profile-input-background" name="email-profile" id="email-profile"  required placeholder="Email"
                            <?php echo "value=$user_email";?>>
                            <span class="help-block">
                                <?php echo $errors["email"]; ?>
                            </span>
                        </div>

                        <div class="form-group">
                          <label for="country">Country</label>
                          <select name="country" id="country" class="form-control">
                              <option>Australia</option>
                          </select>
                          <span class="help-block"></span>
                        </div>
                        
                        <div class="form-group <?php echo $pwerror; ?>">
                            <label for="password-profile">Password</label>
                            <input type="password" class="form-control profile-input-background" name="password-profile" id="password-profile" required
                             placeholder="Password"
                             <?php echo "value=$password";?>>
                            <span class="help-block">
                                 <?php echo $errors["password"];?>
                            </span>
                        </div>  
                        
                        <div class="form-group <?php echo $pwconfirmerror; ?>">
                            <label for="password_confirm-profile">Confirm Password</label>
                            <input type="password" class="form-control profile-input-background" name="password_confirm-profile" id="password_confirm-profile" required
                             placeholder="Confirm Password"
                             <?php echo "value=$password_confirm";?>>
                            <span class="help-block">
                                 <?php echo $errors["password_confirm"];?>
                            </span>
                        </div>                          
            
                        <div class="form-group">
                          <span class="help-block" id="profile-update-message">
                              <?php echo $profile_message;?>
                          </span>
                        </div>
            
                        <div class="text-center">
                            <button type="submit" name="profile" id="profile-button" class="btn btn-block btn-info">Update Account</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
       </div>
       <?php include_once("includes/footer.php");?>
        <script>
            var initial_country = "<?php echo $initial_country ?>";
        </script>
        <script src="js/countries.js"></script>
    </body>
</html>

  