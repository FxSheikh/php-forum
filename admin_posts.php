<?php
session_start();
include_once("autoloader.php");
$page_title="Posts Admin Area";

$categories_list = new Categories();
$categories = $categories_list->returnCategories();
// echo '<pre>',print_r($categories,1),'</pre>';

ob_start();
$disable_message = "";
ob_end_clean();

  
// check if the form is being submitted
if($_SERVER["REQUEST_METHOD"]=="POST"){

  $selectedPost = $_POST['posts'];
  // echo $selectedPost;
  
  $disable_post_query = "UPDATE posts SET post_active=0 WHERE post_id='$selectedPost'";
  
  $connection = new DataStorage();
  $disable_post =  $connection->runUpdateQuery($disable_post_query);
  

  if ($disable_post){
    // echo "post_disabled";
    $disable_message = "The post has been disabled";
  } else {
    $disable_message = "";
  }
}
?>


<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="admin-background">
       <div class="wrapper">
       <?php include_once("includes/pagenavigation.php"); ?>

        <div class="container">
          <div class="row">
            
            <h1 id="posts-h1"class="col-md-12 text-center">Posts Admin Area</h1>
            <hr>
                
            <div class="col-md-4 col-md-offset-4">
                <form action="" method="post">
                        <div class="form-group">
                          <label for="category">Select Category</label>
                          <select class="form-control"  name="category" id="sel_category" required>
                          <option value="">- Select -</option>
                          <?php
                            foreach($categories as $cat_item){
                              $cat_name = $cat_item['cat_name'];
                              $cat_id = $cat_item['cat_id'];
                              echo "<option value=\"$cat_id\">$cat_name</option>";
                            }
                           ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="posts">Select Post</label>
                            <select class="form-control" name="posts" id="sel_post" required>
                              <option value="">- Select -</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                          <span class="help-block" id="disable-message">
                              <?php echo $disable_message;?>
                          </span>
                        </div>
                        
                        <input name="submit" type="submit" value="Disable Post" class="btn btn-info btn-block">
                </form>
            </div>
          </div>
        </div>
      </div>
            <?php include_once("includes/footer.php");?>
         <script src="js/posts.js"></script>
    </body>
</html>





