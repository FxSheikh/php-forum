<?php
class Categories{
  private $categories = array();
  private $database;
  private $query;
  
  public function __construct(){
    $this->database = new DataStorage();

    // print_r($categories);
  }
  
  public function returnCategories(){
    $this->query = "SELECT * from categories";
    $this->categories = $this->database->runSelectQuery($this->query); 
    return $this->categories;
  }
  
  public function returnCategoriesName($category_id){
    
    $category_name_query = "SELECT cat_name from categories where cat_id = '$category_id'";
    $result = $this->database->runSelectQuery($category_name_query);
    $category_name = $result[0]["cat_name"];
    return $category_name;
  }
  
   public function checkCatName($category_name){  
    
    $category_query = "SELECT * FROM categories WHERE cat_name='$category_name'";
    $result = $this->database->runSelectQuery($category_query); 
    $number_rows = $this->database->numRows($category_query); 
    
      if($number_rows>0){
        return true;
      } else {
        return false;
      }
  }
  
  public function addCategory($cat_name,$cat_description){
    $cat_query = "INSERT INTO categories (cat_name,cat_description,cat_date) 
                  values ('$cat_name','$cat_description',NOW())";
    return $this->database->runInsertQuery($cat_query);
  }
  
  
}
?>