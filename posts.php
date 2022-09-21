<?php
session_start();
include_once("autoloader.php");
$page_title="Overwatch Posts";

/*start output buffering to ensure that no headers are sent 
we will redirect the user to the main forum page.*/

ob_start();
$id = (int) $_GET['id'];
if ($id < 1)
{
	header('Location:index.php');
	exit();
}
ob_end_clean();

$cat= new Categories();
$category_name = $cat->returnCategoriesName($id);

$connection = new DataStorage();
// $posts_query = "SELECT * from posts where post_category = '$id'";
// $posts =  $connection->runSelectQuery($posts_query);
print_r($posts);

// session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $reply_message = $_POST['textarea-posts'];
  $post = new AddPost();
  $reply_message_filtered = $post->clear($reply_message);
  $userid = $_SESSION["user_id"];
  $categoryid = $id;
  // echo $reply_message_filtered;

  $post->addPost($reply_message_filtered,$userid,$categoryid);
  
  if ($post) {
    $posting_message = "Your post was added successfully";
  } else {
    $posting_message = "";
  }
 
}

$posts_query = "SELECT * from posts where post_category = '$id' AND post_active=1";
$posts =  $connection->runSelectQuery($posts_query);

$number_rows = $connection->numRows($posts_query);

if ($number_rows == 0){
  // echo "no results found";
  $result_message = "There are currently no posts in this forum.";
  $posts = array();

} 



?>

<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="posts-background">
       <div class="wrapper">
         
        <?php include_once("includes/pagenavigation.php"); ?>
        <header class="container">
          <h1 id="posts-header"><?php echo $category_name?></h1>
          <?php 
           if (!empty($result_message)){echo "<h2 id=\"posts-result\">$result_message</h2>";} 
          ?>
        </header>
      
      
      <?php
      
      foreach ($posts as $post_item) {
      
      $author_id = $post_item["post_by_user"]; 
      $author_name_query = "SELECT user_name from users where user_id = '$author_id'";
      $author_name_result = $connection->runSelectQuery($author_name_query);
      
      $author_name = $author_name_result[0]["user_name"];
      
      $number_posts_query = "SELECT count(*) as total from posts where post_by_user = '$author_id'";
      $number_posts_result = $connection->runSelectQuery($number_posts_query);
      
      $dt = new DateTime($post_item["post_date"]);
      $post_date = $dt->format('d/m/Y');
      
      // $post_date = $post_item["post_date"];
      
      $post_content =  $post_item["post_content"];
      
      $result = $connection->normQuery($number_posts_query);
      $number_posts = $result['total'];

        echo"          <div class=\"container posts-container\">
               <aside class=\"post-author\">
                  <div class=\"author-name\">
                    $author_name  
                  </div>
                  <div class=\"number-posts\">
                    $number_posts" . " posts " ." 
                  </div>
                </aside>     
              <div class=\"post-content\">
                <div class=\"post-date-time\">$post_date</div>
                <div>$post_content</div>
              </div>
            </div>  ";
      
      }
      
      ?>
      
      <?php
      
      if($_SESSION["user_id"]){
        $user_name = $_SESSION["user_name"];
        echo "<div class=\"container\" id=\"posts-form-container\">";
	      echo "<div class=\"textarea-input\">";
	     // echo "<h2 id=\"posts-message\">$posting_message</h2>";
	      
	      if(!empty($posting_message)){

	      echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
	      echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
	      echo "<strong> Well done! $posting_message </strong> ";
        echo "</div>";
	        
	      }

	      
  	    echo "<h1 id=\"posts-footer\">Join the Conversation - <span id=\"username_span\">$user_name</span></h1>";
  	    echo "<form id=\"posts-form\" action=\"\" method=\"post\">";
  	    echo "<textarea id=\"textarea-posts\" name=\"textarea-posts\" required></textarea>";
	     // echo "<div class=\"form-group\">";
      //   echo "<span class=\"help-block\" id=\"reply-error\">";
      //   echo $posting_message;
      //   echo "</span>";
      //   echo "</div>";
        echo "<input type=\"submit\" name=\"submit\" class=\"reply-button\" id=\"submit\" value=\"Add Reply\">";
	     // echo "<span class=\"button-content\">Add Reply</span>";
	     // echo "</button>";
  	    echo "</form>";
	      echo "</div>";
	      echo "</div>";        
      }
      else {
            echo "<div class=\"LoginPlaceholder-details\">"; 
            echo "<div class=\"login-message\">Have something to say? Log in to join the conversation.</div>"; 
            echo "<a class=\"btn btn-primary btn-lg\" id=\"login-post-button\" href=\"login.php\">Log In</a>";
            echo "</div>";
          }  
      ?>

        </div>
             <?php include_once("includes/footer.php");?>
    </body>
</html>





