<?php
class AddPost{

  private $database;
  
  public function __construct(){
    $this->database = new DataStorage();
  }
  
  public function clear($message)
  {
  // 	if(!get_magic_quotes_gpc())
  		$message = addslashes($message);
    	$message = strip_tags($message);
  	  $message = htmlspecialchars($message,ENT_DISALLOWED);
  	
  // 	$safe_message = $this->database->returnSafeString($message);
  // 	return $safe_message;
      return $message;
  }
  
  public function addPost($message,$user_id,$category_id){
      $posts_query = "INSERT INTO posts (post_content,post_date,post_by_user,post_category,post_active) 
      values ('$message',NOW(),$user_id,$category_id,1)";
            
      return $this->database->runInsertQuery($posts_query);
  }

}
?>