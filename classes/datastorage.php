<?php

class DataStorage{
  private $connection;

  private $user; 
  private $host;
  private $password;
  private $database_database_name; 

  private $result = array();
  private $number_rows;
  
  public function __construct(){

    $this->user = getenv('MYSQL_USER');
    $this->host = getenv('MYSQL_HOST');
    $this->password = getenv('MYSQL_PASSWORD');
    $this->database_name = getenv('MYSQL_DATABASE');
    
    $this->connection = mysqli_connect($this->host,$this->user,$this->password,$this->database_name);
    // Check connection
    if ($this->connection->connect_error) { 
      die("Connection failed: " . $this->connection->connect_error);
    } 
    
  }
  
  public function numRows($query){
      $query_result = $this->connection->query($query);
      $number_rows = $query_result->num_rows;
      return $number_rows;
  }
  
  //if query is a select query
  public function runSelectQuery($query){
    $this->emptyArray();
      $query_result = $this->connection->query($query);
      if($query_result -> num_rows > 0){
        //if query returns result
        while($row = $query_result -> fetch_assoc()){
          array_push($this -> result, $row);
        }
        return $this->result;
      }
      else{
        return false;
      }    
  }

  public function normQuery($query){
    $this->emptyArray();
    $result = mysqli_query($this->connection,$query);
    $data=mysqli_fetch_assoc($result);
    return $data;
  }

  //if query is an insert query  
  public function runInsertQuery($query){

      if($this->connection->query($query)){
          // echo "New record created successfully";
          return true;
      }
      else{
          echo "Error: " . $query . "<br>" . $this->connection->error;      
          return false;
      }      
  }

  //if query is a delete query  
  public function runDeleteQuery($query){

      if($this->connection->query($query)){
          // echo "Record delete successfully";
          return true;
      }
      else{
          echo "Error: " . $query . "<br>" . $this->connection->error;      
          return false;
      }      
  }
  
  //if query is an update query  
  public function runUpdateQuery($query){

      if($this->connection->query($query)){
          // echo "Record updated successfully";
          return true;
      }
      else{
          echo "Error: " . $query . "<br>" . $this->connection->error;      
          return false;
      }      
  }  
  
  public function returnSafeString($string_to_filter){
    $escapedValue = mysqli_real_escape_string($this->connection,$string_to_filter);
    return $escapedValue;
  }
  
  private function emptyArray(){
    $this->result = array();
  }
  
  
}
?>


