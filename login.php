<?php
ob_start();
session_start();
include_once("autoloader.php");
$page_title = "Log In to account";
$login = new LoginUser();

// check if a form is being submitted
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["username-login"];
    $password = $_POST["password-login"];

    // user submitted their username
    // sanitize the username value before adding to the query
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    $user = $login->Login($username, $password); 
    
    if ($user){
        // session_regenerate_id();
         // redirect to home page
        header("Location: index.php");
        // exit();
    } else {
        $login_error = $login->login_error;
    }
}
?>

<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="login-background">
     <div class="wrapper">
        <?php include_once("includes/pagenavigation.php"); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form id="login-form" method="post" action="login.php">
                        <div class="form-group">
                            <label class="sr-only" for="useremail" id="username-label">Username</label>
                            <input type="text" name="username-login" id="username-login" required 
                            placeholder="Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password" id="password-label">Password</label>
                            <input type="password" name="password-login" id="password-login" required 
                            placeholder="Password" class="form-control">
                        </div>    
                        <div class="form-group">
                          <span class="help-block" id="login-error">
                              <?php echo $login_error?>
                          </span>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="login" id="login-button" class="btn btn-block btn-info">
                                Log In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
         <?php include_once("includes/footer.php");?>
    </body>
</html>