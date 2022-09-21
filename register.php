<?php
ob_start();
session_start();
include_once("autoloader.php");
$page_title = "Register for an account";
$register = new RegisterUser();     

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $useremail = $_POST["email-register"];
    $username = $_POST["username-register"];
    $country = $_POST["country"];
    $password = $_POST["password-register"];
    $password_confirm = $_POST["password_confirm-register"];
    
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

    //if there are no errors then proceed with the registration of the user
    if(count($errors)==0){
        
        // sanitize the input values except password, because the password gets hashed
        $sanitized_user_email = filter_var($useremail,FILTER_SANITIZE_EMAIL);
        $sanitized_user_name = filter_var($username,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);        

        // check if the username already exists
        $user_exists = $register->isUserExist($sanitized_user_name);
        if($user_exists){
            // the username already exists in the database
            $errors["username"] = "This username already exists";
        }

        // check if the email already exists
        $email_exists = $register->isEmailExist($sanitized_user_email);

        if($email_exists){
            // the email already exists in the database
            $errors["email"] = "This email already exists";
        } 
        
        if(count($errors)==0){
            
            // if there are no errors we need to register the user
            $register->userRegister($sanitized_user_name,$sanitized_user_email,$password,$country);
           
            if(!$register){
                //$errors["reg_error"] = "error, cannot create account";
                echo "Could not create account";
            } 
            else {
                //--------- account created successfully
                //--------- log user in
                
                $register->registerLogin($sanitized_user_email);
                // redirect to home page
                header("location:index.php");
            }   
        }
        
    } 
}
?>
<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="register-background">
        <div class="wrapper">
        <?php include_once("includes/pagenavigation.php"); ?>
        <div class="container">
            <div class="row">
                <h1 id="reg-h1"class="col-md-12 text-center">Create An Account</h1>
                <hr>
                <div class="col-md-4 col-md-offset-4">
                    <form id="register-form" method="post" action="register.php">
                       
                        <?php 
                            if($errors["username"]){ $usernameerror = "has-error"; }
                            if($errors["email"]){ $emailerror = "has-error"; }
                            if($errors["password"]){$pwerror = "has-error"; }
                                else{$pwerror = "has-success"; }
                            if($errors["password_confirm"]){$pwconfirmerror = "has-error"; }
                                else{$pwconfirmerror = "has-success"; }
                        ?>
                        
                        <div class="form-group <?php echo $usernameerror; ?>">
                            <label for="username-register">Username</label>
                            <input type="text" class="form-control reg-input-background" name="username-register" id="username-register" required placeholder="Username"
                            <?php echo "value=$username";?>>
                            <span class="help-block">
                                <?php echo $errors["username"]; ?>
                            </span>
                        </div>                        
                        
                        <div class="form-group <?php echo $emailerror; ?>">
                            <label for="email-register">Email</label>
                            <input type="email" class="form-control reg-input-background" name="email-register" id="email-register"  required placeholder="Email"
                            <?php echo "value=$useremail";?>>
                            <span class="help-block">
                                <?php echo $errors["email"]; ?>
                            </span>
                        </div>

                        <div class="form-group">
                          <label for="country">Country</label>
                          <select name="country" id="country" class="form-control">
                          </select>
                          <span class="help-block"></span>
                        </div>
                        
                        <div class="form-group <?php echo $pwerror; ?>">
                            <label for="password-register">Password</label>
                            <input type="password" class="form-control reg-input-background" name="password-register" id="password-register" required placeholder="Password"
                             <?php echo "value=$password";?>>
                            <span class="help-block">
                                 <?php echo $errors["password"];?>
                            </span>
                        </div>  
                        
                        <div class="form-group <?php echo $pwconfirmerror; ?>">
                            <label for="password_confirm-register">Confirm Password</label>
                            <input type="password" class="form-control reg-input-background" name="password_confirm-register" id="password_confirm-register" 
                            required placeholder="Confirm Password"
                             <?php echo "value=$password_confirm";?>>
                            <span class="help-block">
                                 <?php echo $errors["password_confirm"];?>
                            </span>
                        </div>                          
            
                        <div class="text-center">
                            <button type="submit" name="register" id="register-button" class="btn btn-block btn-info">Register Account</button>
                        </div>
                        
                        <p id="already-registered">Already registered ?
                            <a href="login.php">Login here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        
        </div>
        
             <?php include_once("includes/footer.php");?>
             
        <!--php include_once("includes/sticky_footer.php");-->
        <script>
            var initial_country = "Australia";
        </script>
        <script src="js/countries.js"></script>
    </body>
</html>

  