<?php
session_start();
include_once("autoloader.php");
$page_title="Home Page"
?>

<?php 
$categories_list = new Categories();
$categories = $categories_list->returnCategories();
// echo '<pre>',print_r($categories,1),'</pre>';

// echo '<pre>' . print_r($_SESSION) . '</pre>';

?>

<!doctype html>
<html>
    <?php include_once("includes/head.php");?>
    <body class="homepage-background">
        <div class="wrapper">
        <?php include_once("includes/pagenavigation.php"); ?>
            <header class="homepage-header">
        			<div class="welcome-container">
        				<div class="container">
        					<img src="images/game-logo-overwatch.png"/>
        					<p class="welcome-text">Welcome to the Overwatch Forum</p>
        				</div>
        			</div>
            </header>
            
        <div class="container">
            <div class="col-sm-6 col-md-4 pull-right">
              <form class="search-form" role="search" method="post" action="search.php">
                <div class="input-group add-on">
                  <input class="form-control" placeholder="Search all forums" 
                  name="search-input" id="search-input" type="text" required>
                  <div class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
        </div>
            
            <!--loop through the categories-->
            
        <div class="container">
            
            <?php 
            $number_categories = count($categories);
            // echo $number_categories;
            
            $counter = 0;
            
            foreach ($categories as $cat_item) {
                
            $counter++;
            //   echo $cat_item["cat_name"] . "<br>";
            //   echo $cat_item["cat_description"] . "<br>";
            
            $category_id = $cat_item["cat_id"]; 
            $category_name = $cat_item["cat_name"]; 
            $category_desc = $cat_item["cat_description"];
                    
            if($counter==1) {
                echo "<div class=\"row \">";
            }
            
            // echo "<a href=\"posts.php?id=$category_id\">";
            echo "<div class=\"col-md-6 forum_card\">";
            echo "<h3 class=\"catname\">$category_name</h3>";
            

            echo "<p id=\"forum_card_desc\">$category_desc</p>";
            echo "<a href=\"posts.php?id=$category_id\">View Details</a>";
            echo "<hr>";
            echo "</div>";
            // echo "</a>";
            
            if($counter==2 || $i==$number_categories-1) {
                echo "</div>";
                $counter = 0;
            }
                
            }
            
            ?>
        </div>
        </div>
        <?php include_once("includes/footer.php");?>
         <!--clearing the search input field-->
         <script>$('#search-input').val('');</script>
    </body>
</html>





