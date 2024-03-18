<?php
require_once("../database/database.php");
require_once("../config/config.php");

class BookCatalog{
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

  public function GetBookInformation(){
    try{
      $query = "SELECT * FROM bookcatalog.book_catalog";
  
      // prepare statement
      $this->db->query($query);
  
      // Execute and fetchall data
      $result = $this->db->resultset();
  
      return $result;
 
    } catch(PDOException $e){
      throw $e;
    }
  }

  public function GetSpecificBookInformation($id){
    try{
      $query = "SELECT * FROM bookcatalog.book_catalog WHERE book_id = $id";
      // prepare statement
      $this->db->query($query);
      // Execute and fetchall data
      $result = $this->db->resultset();
      return $result;
    } catch(PDOException $e){
      throw $e;
    }
  }

  public function InsertNewBook($title, $isbn, $author, $publisher, $year, $categoryid){
    try{
      $query = "INSERT INTO bookcatalog.book_catalog (book_title, book_isbn, author, publisher, year_published, category_id)
                VALUES ($title, $isbn, $author, $publisher, $year, $categoryid);";
      $this->db->query($query);
      $this->db->execute();
      $count = $this->db->rowCount();
      if ($count > 0){
        $bookid = $this->db->lastInsertId();
        $this->db->endTransaction();
        return array("IsError" => false, "book_id" => $bookid);
      }
      else{
        $this->db->cancelTransaction();
        return array("IsError" => true);
      }
    } catch(PDOException $e){
      throw $e;
    }
  }

  public function UpdateBookInformation($id, $title, $isbn, $author, $publisher, $year, $categoryid){
    try{
      $query = "UPDATE bookcatalog.book_catalog 
                SET 
                  book_title = $title, 
                  book_isbn = $isbn, 
                  author = $author, 
                  publisher = $publisher, 
                  year_published = $year, 
                  category_id = $categoryid
                WHERE book_id = $id";
      // prepare statement
      $this->db->query($query);
      // Execute and fetchall data
      $result = $this->db->execute();
      return array($result, "success");
    } catch(PDOException $e){
      throw $e;
    }
  }



  // 
  public function DeleteSpecificBook($id){
    try{
      $query = "DELETE FROM bookcatalog.book_catalog WHERE book_id = $id";
      // prepare statement
      $this->db->query($query);
      // Execute and fetchall data
      $result = $this->db->execute();
      return $result;
    } catch(PDOException $e){
      throw $e;
    }
  }


}



?>