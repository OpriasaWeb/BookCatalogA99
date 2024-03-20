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
      $query = "SELECT bc.book_id, bc.author, bc.book_isbn, bc.book_title, bc.publisher, bc.year_published, rc.category_name, bc.status
                FROM bookcatalog.book_catalog bc
                LEFT JOIN bookcatalog.ref_category rc 
                ON rc.category_id = bc.category_id
                ORDER BY book_id DESC";

      // prepare statement
      $this->db->query($query);
  
      // Execute and fetchall data
      $result = $this->db->resultset();
  
      return $result;
 
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }

  public function GetBookInformationStatus($status){
    try{
      $status = (int)$status;
      $query = "SELECT bc.book_id, bc.author, bc.book_isbn, bc.book_title, bc.publisher, bc.year_published, rc.category_name, bc.status
                FROM bookcatalog.book_catalog bc
                LEFT JOIN bookcatalog.ref_category rc 
                ON rc.category_id = bc.category_id
                WHERE bc.status = $status
                ORDER BY book_id DESC";

      // prepare statement
      $this->db->query($query);
  
      // Execute and fetchall data
      $result = $this->db->resultset();
  
      return $result;
 
    } catch(PDOException $e){
      return $e->getMessage();
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
      return $e->getMessage();
    }
  }

  public function GetToDelete($id){
    try{
      $query = "SELECT book_id FROM bookcatalog.book_catalog WHERE book_id = $id";
      // prepare statement
      $this->db->query($query);
      // Execute and fetchall data
      $result = $this->db->resultset();
      return $result;
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }

  public function InsertNewBook($title, $isbn, $author, $publisher, $categoryid){
    try{
      $this->db->startTransaction();
      $query = "INSERT INTO bookcatalog.book_catalog (book_title, book_isbn, author, publisher, year_published, category_id, status)
                VALUES (:title, :isbn, :author, :publisher, NOW(6), :categoryid, 1);";
      $this->db->query($query);
      $this->db->bind(':title', $title);
      $this->db->bind(':isbn', $isbn);
      $this->db->bind(':author', $author);
      $this->db->bind(':publisher', $publisher);
      $this->db->bind(':categoryid', $categoryid);
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
      return $e->getMessage();
    }
  }

  public function UpdateBookInformation($id, $title, $isbn, $author, $publisher, $categoryid){
    try{
      $this->db->startTransaction();
      $query = "UPDATE bookcatalog.book_catalog 
                SET 
                  book_title = :title, 
                  book_isbn = :isbn, 
                  author = :author, 
                  publisher = :publisher, 
                  category_id = :categoryid,
                  date_updated = NOW(6)
                WHERE book_id = :id";
      $this->db->query($query);
      $this->db->bind(':id',$id);
      $this->db->bind(':title',$title);
      $this->db->bind(':isbn',$isbn);
      $this->db->bind(':author',$author);
      $this->db->bind(':publisher',$publisher);
      $this->db->bind(':categoryid',$categoryid);
      $this->db->execute();
      $count = $this->db->rowCount();
      if ($count > 0){
        $this->db->endTransaction();
        return array("IsError" => false);
      }
      else{
        $this->db->cancelTransaction();
        return array("IsError" => true);
      }
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }

  public function DeleteSpecificBook($id){
    try{
      $this->db->startTransaction();
      $query = "UPDATE bookcatalog.book_catalog SET status = 2 WHERE book_id = :id";
      // $query = "DELETE FROM bookcatalog.book_catalog WHERE book_id = :id";
      // prepare statement
      $this->db->query($query);
      $this->db->bind(':id', $id);
      // Execute and fetchall data
      $this->db->execute();
      $count = $this->db->rowCount();
      if ($count > 0){
        $this->db->endTransaction();
        return array("IsError" => false);
      }
      else{
        $this->db->cancelTransaction();
        return array("IsError" => true);
      }
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }


}



?>