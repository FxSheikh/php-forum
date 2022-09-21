<?php
session_start();
include_once("autoloader.php");
$page_title="Categories Admin Area";

$connection = new DataStorage();

// using the get to delete a selected category
if (isset($_GET['delete'])) {
    $get_cat_id = (int)$_GET['delete'];
    if ($get_cat_id < 1){
        // echo"Not valid";
        header('Location:admin_cat.php');
    } else {
    // echo $get_cat_id;
    $delete_query = "DELETE FROM categories WHERE cat_id = '$get_cat_id'";
    $delete = $connection->runDeleteQuery($delete_query);        
    }
} 

$categories = new Categories();
// session_start();

// if (!isset($_SESSION["admin_id"]))
// {
// 	header('Location:index.php');
// 	exit();
// }

?>

<?php

if (isset($_POST['create-cat-button'])) {

    $cat_name = $_POST['cat-name'];
    $cat_description = $_POST['cat-description'];
    
    $errors = array();
  
    // check the category name length
    if(strlen($cat_name) < 6 || strlen($cat_name)>30){
      $errors["cat_name"] = "Category name needs to be more than 6 characters and less than 30 characters";
    }
  
    if(!preg_match('/^[a-z0-9 ]+$/i', $cat_name)) {
    
        if (isset($errors["cat_name"])) {
           $errors["cat_name"] = $errors["cat_name"]." "."and only spaces, A-Z,a-z,0-9 characters are allowed";
        } else {
           $errors["cat_name"] = "Only spaces, A-Z,a-z,0-9 characters are allowed";
        }
    } 

    // check the category description length
    if(strlen($cat_description) < 6 || strlen($cat_description)>100){
      $errors["cat_description"] = "Category description needs to be more than 6 characters and less than 100 characters";
    }

    if(!preg_match('/^[a-z0-9 .]+$/i', $cat_description)) {
    
        if (isset($errors["cat_description"])) {
           $errors["cat_description"] = $errors["cat_description"]." "."and only spaces, dots, A-Z,a-z,0-9 characters are allowed";
        } else {
           $errors["cat_description"] = "Only spaces, dots, A-Z,a-z,0-9 characters are allowed";
        }
    } 
    
    // print_r($errors);
    
    //if there are no errors then proceed with the registration of the user
    if(count($errors)==0){
        
        // sanitize the category name and description input values
        $sanitized_cat_name = filter_var($cat_name,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        $sanitized_cat_description = filter_var($cat_description,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);  

        // check if the category name already exists
        $category_exists = $categories->checkCatName($sanitized_cat_name);
        
        if($category_exists){
            $cat_exists_message = "This category name already exists";
            // echo $cat_exists_message;
            
        } else {
            // the category name does not exist so insert the category
            $categories->addCategory($sanitized_cat_name,$sanitized_cat_description);
            $cat_insert_message = "The category was added successfully";
        }
        
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
                <h1 id="cat-h1"class="col-md-12 text-center">Category Admin Area</h1>
                <hr>
                <?php 
                    if($errors["cat_name"]){ $catname_error = "has-error"; }
                    if($errors["cat_description"]){ $catdesc_error = "has-error"; }
                ?>
                <div class="col-md-4 col-md-offset-4">
                    <form id="create-cat-form" method="post" action="">
                        <div class="form-group <?php echo $catname_error; ?>">
                            <label for="cat-name" id="category-label">Category Name:</label>
                            <input type="text" name="cat-name" id="cat-name" required readonly 
                            class="form-control cat-input-background" value="<?php echo $cat_name ?>">
                            
                            <span class="help-block">
                                <?php echo $errors["cat_name"]; ?>
                            </span>
                            
                        </div>
                        
                        <div class="form-group <?php echo $catdesc_error; ?>">
                          <label for="cat-description" id="cat-description-label">Category Description:</label>
                           <textarea class="form-control" name="cat-description" required maxlength=100></textarea>
                                                  
                            <span class="help-block">
                                <?php echo $errors["cat_description"]; ?>
                            </span>
                            
                        </div>                    
                        
                        <div class="form-group">
                          <span class="help-block" id="category-error">
                              <?php echo $cat_exists_message?>
                          </span>
                        </div>

                       <?php
                          if(!empty($cat_insert_message)){
                             echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
                             echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                             <span aria-hidden=\"true\">&times;</span></button>";
                             echo "<strong>$cat_insert_message </strong> ";
                             echo "</div>";
                          }
	                    ?>
	                    
                        <div class="text-center">
                            <button type="submit" name="create-cat-button" id="create-cat-button" class="btn btn-block btn-info">
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

    <?php 
        
        $cat_list_query = "SELECT * FROM categories WHERE cat_id>6";
        $category_list =  $connection->runSelectQuery($cat_list_query);
        $number_rows = $connection->numRows( $cat_list_query);
        
        if ($number_rows == 0){
          // echo "no results found";
          $result_message = "There are currently no categories to delete";
          $category_list = array();
        
        } 
    ?>
                <div class="row"> 
                 <h2 class="text-center del-cats">Delete Categories</h2>
                      <div class="col-md-4 col-md-offset-4">
                          <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Category Id</th>
                                    <th colspan=2>Category Name</th>
                                 </tr>
                            </thead>
                            <tbody>

                            <?php
                                foreach ($category_list as $cat_item) {
                                    $cat_id = $cat_item['cat_id'];
                                    $cat_name = $cat_item['cat_name'];
                                    echo "<tr>";
                                    echo "<td>{$cat_id}</td>";
                                    echo "<td>{$cat_name}</td>";
                                    // echo "<td><a href='admin.php?delete={$cat_id}'>Delete</a></td>";
                                    echo "<td class=\"align-delete\"><a href='admin_cat.php?delete={$cat_id}'> 
                                         <input type='button' class='btn btn-primary' value='Delete'> </a></td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                          </table>
                        <?php if (!empty($result_message)){echo "<p id=\"list-result\">$result_message</p>";}?>
                      </div>
                </div>
      </div>
      
      </div>
      <?php include_once("includes/footer.php");?>
          <!--clearing the create category input field-->
         <script>
         
         $('#create-category').val('')
         document.getElementById("cat-name").readOnly = false;
         
         </script>    
    </body>
</html>

