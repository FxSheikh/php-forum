<?php
session_start();
include_once("autoloader.php");
$page_title="Search Results";
?>

<?php
if (empty($_POST['search-input'])) {
  header('Location: index.php');
  exit;
}
    
// check if the form is being submitted
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $search = $_POST["search-input"];
  
  $search = htmlspecialchars($search,ENT_DISALLOWED);
   
  $sanitized_search = filter_var($search,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH);  
  
  // echo $search;
  $search_query = "SELECT * from posts WHERE post_content LIKE '%$sanitized_search%'";
  
  // echo $search_query;
  
  $connection = new DataStorage();
  $posts =  $connection->runSelectQuery($search_query);
  
  $number_rows = $connection->numRows($search_query);
  
  if ($number_rows == 0){
    // echo "no results found";
    $result_message = "No results could be found. Please check your spelling or try different keywords.";
    $posts = array();

  } 
  
}

?>

<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="posts-background">
       <div class="wrapper">
        <?php include_once("includes/pagenavigation.php"); ?>
        <header class="container">
          <h1 id="posts-header">Search Results For "<?php echo $search?>"</h1>
          <?php 
           if (!empty($result_message)){echo "<h2 id=\"search-result\">$result_message</h2>";} 
          ?>
        </header>
      
      
      <?php
      
      foreach ($posts as $post_item) {

      $author_id = $post_item["post_by_user"];
      
      $full_query = "SELECT posts.*, categories.cat_name, users.user_name FROM posts 
                     INNER JOIN categories on posts.post_category = categories.cat_id
                     INNER JOIN users on posts.post_by_user = users.user_id
                     WHERE posts.post_by_user = '$author_id'";
                     
      $query_result = $connection->runSelectQuery($full_query);                     
                     
      $category = $post_item["post_category"]; 
      
      $dt = new DateTime($post_item["post_date"]);
      $post_date = $dt->format('d/m/Y');
      
      // $post_date = $post_item["post_date"];
      $post_content =  $post_item["post_content"];
      $author_name = $query_result[0]["user_name"];
      $category_name = $query_result[0]["cat_name"];
      
      $number_posts_query = "SELECT count(*) as total from posts where post_by_user = '$author_id'";
      $result = $connection->normQuery($number_posts_query);
      $number_posts = $result['total'];

        
      echo  "<div class=\"container posts-container search-lists\">
               <aside class=\"post-author\">
                  <div class=\"author-name\">
                    $author_name 
                  </div>
                  <div class=\"number-posts\">
                    $number_posts
                  </div>
                </aside>     
              <div class=\"post-content\">
                <div class=\"cat-name\">Category: $category_name</div>
                <div class=\"post-date-time\">$post_date</div>
                <div>$post_content</div>
              </div>
            </div>  ";
      
      }
    
      ?>
      </div>
      <?php include_once("includes/footer.php");?>  
    </body>
</html>