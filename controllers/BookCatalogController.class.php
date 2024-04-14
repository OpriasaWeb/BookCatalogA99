<?php

session_start();

require("../models/book_catalog.php");
require("../models/ref_category.php");


class BookCatalogController{
  private $bookcatalog;
  private $refcategory;
  
  public function __construct(){
    $this->bookcatalog = new BookCatalog();
    $this->refcategory = new RefCategory();
  }

  // ----- Book Catalog models ----- //
  public function GetBookInformation(){
    $getbookinformation = $this->bookcatalog->GetBookInformation();
    return $getbookinformation;
  }

  public function GetBookInformationStatus($status){
    $getbookinfostatus = $this->bookcatalog->GetBookInformationStatus($status);
    return $getbookinfostatus;
  }

  public function GetSpecificBookInformation($id){
    $getspecificbookinfo = $this->bookcatalog->GetSpecificBookInformation($id);
    return $getspecificbookinfo;
  }

  public function InsertNewBook($title, $isbn, $author, $publisher, $categoryid){
    $insertnewbook = $this->bookcatalog->InsertNewBook($title, $isbn, $author, $publisher, $categoryid);
    return $insertnewbook;
  }

  public function UpdateBookInformation($id, $title, $isbn, $author, $publisher, $categoryid){
    $updatebookinformation = $this->bookcatalog->UpdateBookInformation($id, $title, $isbn, $author, $publisher, $categoryid);
    return $updatebookinformation;
  }

  public function DeleteSpecificBook($id){
    $deletespecificbook = $this->bookcatalog->DeleteSpecificBook($id);
    return $deletespecificbook;
  }

  public function GetToDelete($id){
    $gettodelete = $this->bookcatalog->GetToDelete($id);
    return $gettodelete;
  }

  public function SearchBook($name, $status){
    $searchbook = $this->bookcatalog->SearchBook($name, $status);
    return $searchbook;
  }
  // ----- Book Catalog models ----- //

  // ----------------------------------------------------------------------------------------------------------------- //

  // ----- Ref Category models ----- //
  public function SpreadCategory(){
    $spreadcategory = $this->refcategory->SpreadCategory();
    return $spreadcategory;
  }

  public function GetCategory($id){
    $getcategory = $this->refcategory->GetCategory($id);
    return $getcategory;
  }
  // ----- Ref Category models ----- //

}

// Instance of book catalog controller
$bookcatalogcontroller = new BookCatalogController();

$funcname = $_POST['function_type'];

if($funcname === "spreadCategory"){
  try{
    $data_array = array();
    $spreadcategory = $bookcatalogcontroller->SpreadCategory();
    $data_array[] = $spreadcategory;
    echo json_encode($data_array);
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "selectedCategory"){
  try{
    $data_array = array();
    $selectedcategory = $bookcatalogcontroller->SpreadCategory();
    $data_array[] = $selectedcategory;
    echo json_encode($data_array);
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "refreshTable"){
  try{
    $returndata = array();
    $getbookinfo = $bookcatalogcontroller->GetBookInformation();
    foreach($getbookinfo as $row){
      $arraydata = array();
      $arraydata[] = $row['book_title'];
      $arraydata[] = $row['book_isbn'];
      $arraydata[] = $row['author'];
      $arraydata[] = $row['publisher'];
      $arraydata[] = $row['year_published'];
      $arraydata[] = $row['category_name'];

      if($row['status'] != 2){
        $arraydata[] = '<button type="button" class="btn btn-secondary edit-button" id="edit" value="'.$row['book_id'].'" data-bookid="'.$row['book_id'].'">Edit</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger delete-button" id="delete" value="'.$row['book_id'].'" data-bookid="'.$row['book_id'].'">Delete</button>';
      }
      else{
        $arraydata[] = '<p class="text-decoration-line-through">Deleted</p>';
      }

      
      $returndata[] = $arraydata;
    }
    echo json_encode($returndata);
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "currentStatus"){
  try{
    if(isset($_POST['status'])){
      $status = $_POST['status'];
      
      if($status == "0"){
        $getbookinfo = $bookcatalogcontroller->GetBookInformation();
      }
      else if($status == "1"){
        $getbookinfo = $bookcatalogcontroller->GetBookInformationStatus($status);
      }
      else if($status == "2"){
        $getbookinfo = $bookcatalogcontroller->GetBookInformationStatus($status);
      }
      $returndata = array();
      foreach($getbookinfo as $row){
        $arraydata = array();
        $arraydata[] = $row['book_title'];
        $arraydata[] = $row['book_isbn'];
        $arraydata[] = $row['author'];
        $arraydata[] = $row['publisher'];
        $arraydata[] = $row['year_published'];
        $arraydata[] = $row['category_name'];

        if($row['status'] != 2){
          $arraydata[] = '<button type="button" class="btn btn-secondary edit-button" id="edit" value="'.$row['book_id'].'" data-bookid="'.$row['book_id'].'">Edit</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger delete-button" id="delete" value="'.$row['book_id'].'" data-bookid="'.$row['book_id'].'">Delete</button>';
        }
        else{
          $arraydata[] = '<p class="text-decoration-line-through">Deleted</p>';
        }

        $returndata[] = $arraydata;
      }
      echo json_encode($returndata);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "insertBook"){
  try{
    if(isset($_POST['title']) && isset($_POST['isbn']) && isset($_POST['author']) && isset($_POST['publisher']) && isset($_POST['category'])){
      $title = $_POST['title'];
      $isbn = (int)$_POST['isbn'];
      $author = $_POST['author'];
      $publisher = $_POST['publisher'];
      // $year = $_POST['year'];
      $category = (int)$_POST['category'];
    
      $addnewbook = $bookcatalogcontroller->InsertNewBook($title, $isbn, $author, $publisher, $category);
      echo json_encode($addnewbook);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "selectToDelete"){
  try{
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $returnid = 0;
      $gettodelete = $bookcatalogcontroller->GetToDelete($id);
      foreach($gettodelete as $row){
        $returnid = (int)$row['book_id'];
      }
      echo json_encode($returnid);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "deleteBook"){
  try{
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $deletebook = $bookcatalogcontroller->DeleteSpecificBook($id);
      echo json_encode($deletebook);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "selectSpecificBook"){
  try{
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $getspecificbook = $bookcatalogcontroller->GetSpecificBookInformation($id);
      echo json_encode($getspecificbook);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "updateBook"){
  try{
    if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['isbn']) && isset($_POST['author']) && isset($_POST['publisher']) && isset($_POST['category'])){
      $title = $_POST['title'];
      $isbn = (int)$_POST['isbn'];
      $author = $_POST['author'];
      $publisher = $_POST['publisher'];
      // $year = $_POST['year'];
      $category = (int)$_POST['category'];
      $id = (int)$_POST['id'];
    
      $updatebook = $bookcatalogcontroller->UpdateBookInformation($id, $title, $isbn, $author, $publisher, $category);
      echo json_encode($updatebook);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($funcname === "searchBook"){
  try{
    if(isset($_POST['name']) && isset($_POST['status'])){
      $name = $_POST['name'];
      $status = $_POST['status'];
      $searchbook = $bookcatalogcontroller->SearchBook($name, $status);
      $returndata = array();
      foreach($searchbook as $row){
        $arraydata = array();
        $arraydata[] = $row['book_title'];
        $arraydata[] = $row['book_isbn'];
        $arraydata[] = $row['author'];
        $arraydata[] = $row['publisher'];
        $arraydata[] = $row['year_published'];
        $arraydata[] = $row['category_name'];

        if($row['status'] != 2){
          $arraydata[] = '<button type="button" class="btn btn-secondary edit-button" id="edit" value="'.$row['book_id'].'" data-bookid="'.$row['book_id'].'">Edit</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger delete-button" id="delete" value="'.$row['book_id'].'" data-bookid="'.$row['book_id'].'">Delete</button>';
        }
        else{
          $arraydata[] = '<p class="text-decoration-line-through">Deleted</p>';
        }
        $returndata[] = $arraydata;
      }
      echo json_encode($returndata);
    }
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}


?>