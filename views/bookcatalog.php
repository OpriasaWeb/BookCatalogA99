<?php
require_once("../config/config.php");

$baseUrl = ProjectConfig::$baseurl;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Catalog</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- jQuery CDN -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- <script src = "https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js"></script> -->

  <!-- ajax CDN -->
  <!-- <script src = "https://ajax.aspnetCDN.com/ajax/jQuery/jQuery-1.9.0.min.js"></script> -->

  <!-- jQuery cdn -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- jqGrid 4.1.1 -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/5.8.2/js/jquery.jqGrid.min.js" integrity="sha512-MMPWQuKgra1rVM2EEgZDWD3ZKmaNALAfKEb+zgkDgET/AS8bCWecd12zqYWoYQ+gpBqoIebb4k/686xHO4YkLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  
  <!-- <script src="https://cdn.jsdelivr.net/npm/jqgrid@4.6.4/plugins/grid.postext.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jqgrid@4.6.4/css/ui.jqgrid.min.css"> -->
  <!-- jqGrid 4.1.1 -->

  <!-- jQuery AJAX -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <!-- jQuery UI CSS -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
  <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

  
</head>
<body>

  <script language ="javascript" type="text/javascript">

    $(document).ready(function(){
      var base_url = "<?php echo $baseUrl ?>";

      $('#backadd').click(function(){
        $('#addmodal').modal('hide');
      })

      let datatable = $('#myTable').DataTable({
        responsive: true,
        searching: false,
        bFilter: false,
        bInfo: false,
        ordering: false,
        lengthChange: false,
        order: []
      });

      // Spread the categories for add and update
      function spreadCategory(){
        var spreadCategory = "spreadCategory";
        $.ajax({
          url:base_url + "controllers/bookcatalogHandler.php",
          // url:"../controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return spreadCategory;
            },
          },
          dataType: 'json',
          success: (r) => {
            $.each(r, (k, v) => {
              $('#category').append(`<option value="${v.category_id}">${v.category_name}</option>`);
            })
          },
          error: (xhr, status, error) => {
            console.log(error)
          }
        })
      }
      // Call the spread category
      spreadCategory()

      // Automatic call of data to present in datatables
      function spreadCurrentData(){
        var spreadCurrentData = "spreadCurrentData";
        $.ajax({
          url:base_url + "controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return spreadCurrentData;
            },
          },
          dataType: 'json',
          success: (r) => {
            datatable.clear();
            datatable.rows.add(r);
            datatable.draw(false);
          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Perform select to edit*
      function selectSpecificBook(id){
        var selectSpecificBook = "selectSpecificBook";
        $.ajax({
          url:base_url + "controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return selectSpecificBook;
            },
            id: function(){
              return id;
            },
          },
          dataType: 'json',
          success: (r) => {
            console.log(r)
            // datatable.clear();
            // datatable.rows.add(r);
            // datatable.draw(false);

          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Perform add
      function insertBook(title, isbn, author, publisher, year, category){
        var insertBook = "insertBook";
        $.ajax({
          url:base_url + "controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return insertBook;
            },
            title: function(){
              return title
            },
            isbn: function(){
              return isbn
            },
            author: function(){
              return author
            },
            publisher: function(){
              return publisher
            },
            year: function(){
              return year
            },
            category: function(){
              return category
            },
          },
          dataType: 'json',
          success: (r) => {
            console.log(r)
            // datatable.clear();
            // datatable.rows.add(r);
            // datatable.draw(false);

          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Perform update
      function updateBook(title, isbn, author, publisher, year, category, id){
        var updateBook = "updateBook";
        $.ajax({
          url:base_url + "controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return updateBook;
            },
            title: function(){
              return title
            },
            isbn: function(){
              return isbn
            },
            author: function(){
              return author
            },
            publisher: function(){
              return publisher
            },
            year: function(){
              return year
            },
            category: function(){
              return category
            },
            id: function(){
              return id
            },
          },
          dataType: 'json',
          success: (r) => {
            console.log(r)
            
            // datatable.clear();
            // datatable.rows.add(r);
            // datatable.draw(false);

          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Perform delete
      function deleteBook(id){
        var deleteBook = "deleteBook";
        $.ajax({
          url:base_url + "controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return deleteBook;
            },
            id: function(){
              return id
            },
          },
          dataType: 'json',
          success: (r) => {
            console.log(r)
          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Add buttons and call function
      $('#addbook').click(function(){
        var bookTitle = $('#title').val()
        var bookISBN = $('#isbn').val()
        var bookAuthor = $('#author').val()
        var bookPublisher = $('#publisher').val()
        var bookYear = $('#year').val()
        var bookCategory = $('#category').val()

        if(bookTitle == "" || bookISBN == "" || bookAuthor == "" ||
        bookPublisher == "" || bookYear == "" || bookCategory == "-100"){
          console.log("Please fill-up everything.")
        }
        else{
          insertBook(bookTitle, bookISBN, bookAuthor, bookPublisher, bookYear, bookCategory)
        }
          
          
          
      })

      // Update functions such as buttons, modal, etc



      // Delete functions such as buttons, modal, etc

    })


  </script>
  <div class="container-fluid">
    <div class="mt-5"></div>
  </div>
  
  <div class="container">
    <div id="add" class="ml-auto">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal">ADD</button>
    </div>
    <div class="row">
      <div class="col-md">
        <table id="myTable" class="display">
          <thead>
            <tr>
              <th scope="col">TITLE</th>
              <th scope="col">ISBN</th>
              <th scope="col">AUTHOR</th>
              <th scope="col">PUBLISHER</th>
              <th scope="col">YEAR PUBLISHED</th>
              <th scope="col">CATEGORY</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <!-- <tr>
              <td>Row 1 Data 1</td>
              <td>Row 1 Data 2</td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SECTION MODALS -->
  <section>
    <div class="modal" tabindex="-1" id="addmodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add new book</h5>
          </div>
          
          <div class="modal-body">
            <label for="">Title:</label>
            <input class="form-control" id="title" type="text" aria-label="default input example">
            <label for="">ISBN:</label>
            <input class="form-control" id="isbn" type="text" aria-label="default input example">
            <label for="">Author:</label>
            <input class="form-control" id="author" type="text" aria-label="default input example">
            <label for="">Publisher:</label>
            <input class="form-control" id="publisher" type="text" aria-label="default input example">
            <label for="">Date:</label>
            <input class="form-control" id="year" type="date" aria-label="default input example">
            <label for="">Category:</label>
            <select class="form-select" id="category" aria-label="Default select example">
              <option value="-100">Select Category</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="backadd">Back</button>
            <!-- data-bs-dismiss="modal" -->
            <button type="button" class="btn btn-primary" id="addbook">Add</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  

</body>
</html>

