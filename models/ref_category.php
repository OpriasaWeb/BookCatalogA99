<?php
require_once("../database/database.php");
require_once("../config/config.php");

class RefCategory{
  private $db;

  public function __construct()
  {
    $host = ProjectConfig::$book['host'];
    $port = ProjectConfig::$book['port'];
    $user = ProjectConfig::$book['user'];
    $pass = ProjectConfig::$book['password'];
    $dbname = "bookcatalog";

    $this->db = new Database($host, $dbname, $port, $user, $pass);
  }

  public function SpreadCategory(){
    
    try{
     
      $query = "SELECT * FROM bookcatalog.ref_category";
  
      // prepare statement
      $this->db->query($query);
  
      // Execute and fetchall data
      $result = $this->db->resultset();
  
      return $result;
  
    } catch(PDOException $e){
      throw $e;
    }
 
  }

  public function GetCategory($id){
    
    try{
     
      $query = "SELECT category_name FROM bookcatalog.ref_category WHERE category_id = $id";
  
      // prepare statement
      $this->db->query($query);
  
      // Execute and fetchall data
      $result = $this->db->resultset();
  
      return $result;
  
    } catch(PDOException $e){
      throw $e;
    }
 
  }

}



?>