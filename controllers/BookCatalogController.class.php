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

  // Book Catalog models
  public function GetBookInformation(){
    $getbookinformation = $this->bookcatalog->GetBookInformation();
    return $getbookinformation;
  }

  public function GetSpecificBookInformation($id){
    $getspecificbookinfo = $this->bookcatalog->GetSpecificBookInformation($id);
    return $getspecificbookinfo;
  }

  public function InsertNewBook($title, $isbn, $author, $publisher, $year, $categoryid){
    $insertnewbook = $this->bookcatalog->InsertNewBook($title, $isbn, $author, $publisher, $year, $categoryid);
    return $insertnewbook;
  }

  public function UpdateBookInformation($id, $title, $isbn, $author, $publisher, $year, $categoryid){
    $updatebookinformation = $this->bookcatalog->UpdateBookInformation($id, $title, $isbn, $author, $publisher, $year, $categoryid);
    return $updatebookinformation;
  }

  public function DeleteSpecificBook($id){
    $deletespecificbook = $this->bookcatalog->DeleteSpecificBook($id);
    return $deletespecificbook;
  }

  // Ref Category models
  public function SpreadCategory(){
    $spreadcategory = $this->refcategory->SpreadCategory();
    return $spreadcategory;
  }

  public function GetCategory($id){
    $getcategory = $this->refcategory->GetCategory($id);
    return $getcategory;
  }


}


?>