<?php

require("./BookCatalogController.class.php");

$bookcatalogcontroller = new BookCatalogController();

$functionname = $_POST['function_type'];

if($functionname == "spreadCategory"){
  try{
    $spreadcategory = $bookcatalogcontroller->SpreadCategory();
    echo json_encode($spreadcategory);
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}
else if($functionname == "insertBook"){
  try{
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $year = $_POST['year'];
    $category = $_POST['category'];
  
    $addnewbook = $bookcatalogcontroller->InsertNewBook($title, $isbn, $author, $publisher, $year, $category);
    var_dump($addnewbook);
    echo json_encode($addnewbook);
  }
  catch(PDOException $e){
    return $e->getMessage();
  }
}



?>