<?php
require_once("../config/config.php");
require_once("../config/errormessages.php");

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
      inputChange();
      var base_url = "<?php echo $baseUrl ?>";

      $('#backadd').click(function(){
        $('#title').val('')
        $('#isbn').val('')
        $('#author').val('')
        $('#publisher').val('')
        // var bookYear = $('#year').val()
        $('#category').val('-100')
        $('#addmodal').modal('hide');
      })

      $('#okMessage').click(function(){
        $('#addmodal').modal('show');
        $('#modalerror').modal('hide');
      })

      // Update success and validation button ok
      $('#editSuccessOk').click(function(){
        $('#editsuccess').modal('hide')
        // Refresh the table
        refreshTable();
      })

      let datatable = $('#myTable').DataTable({
        responsive: true,
        searching: false,
        bFilter: false,
        bInfo: false,
        ordering: false,
        lengthChange: false,
        order: [],
      });

      function refreshTable(){
        
        var refreshTable = "refreshTable";
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
          // url:"../controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return refreshTable;
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
          }
        })

      }
      refreshTable()

      

      // Spread the categories for add and update
      function spreadCategory(value){
        var spreadCategory = "spreadCategory";
        // let toStringVal = value.toString();
        let toStringVal = (value !== null && value !== undefined) ? value : '';
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
          // url:"../controllers/bookcatalogHandler.php",
          type: 'POST',
          data: {
            function_type: function(){
              return spreadCategory;
            },
          },
          dataType: 'json',
          success: (r) => {
            $('#category').empty();
            $('#category').append(`<option value="-100">Select category</option>`);
            $.each(r[0], (key, value) => {
              $('#category').append(`<option value="${value['category_id']}">${value['category_name']}</option>`);
            })

            $('#editmodal .modal-content #category_id').empty();
            $('#editmodal .modal-content #category_id').append(`<option value="-100">Select category</option>`);

            for(let i = 0; i < r[0].length; i++){
              if(toStringVal == r[0][i]['category_id']){
                $('#editmodal .modal-content #category_id').append(`<option selected value="${r[0][i]['category_id']}">${r[0][i]['category_name']}</option>`);
              }
              else{
                $('#editmodal .modal-content #category_id').append(`<option value="${r[0][i]['category_id']}">${r[0][i]['category_name']}</option>`);
              }
            }
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
          url:base_url + "controllers/BookCatalogController.class.php",
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
          url:base_url + "controllers/BookCatalogController.class.php",
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

            // Empty the modal each click of the edit button
            $('#editmodal .modal-content').empty()

            let author;
            let bookid;
            let bookisbn;
            let booktitle;
            let categoryid;
            let publisher;
            for(let i = 0; i < r.length; i++){
              author = r[i]['author']
              bookid = r[i]['book_id']
              bookisbn = r[i]['book_isbn']
              booktitle = r[i]['book_title']
              categoryid = r[i]['category_id']
              publisher = r[i]['publisher']
            }

            let appendEdit = 
            `
              <div class="modal-header">
                <h5 class="modal-title">Update ${booktitle} book</h5>
              </div>
              <div class="modal-body">
                <input type="hidden" id="bookid" value="${bookid}">
                <label for="">Title:</label>
                <input class="form-control" id="title" type="text" aria-label="default input example" value="${booktitle}">
                <label for="">ISBN:</label>
                <input class="form-control" id="isbn" type="text" aria-label="default input example" value="${bookisbn}">
                <label for="">Author:</label>
                <input class="form-control" id="author" type="text" aria-label="default input example" value="${author}">
                <label for="">Publisher:</label>
                <input class="form-control" id="publisher" type="text" aria-label="default input example" value="${publisher}">
                <!-- <label for="">Date:</label>
                <input class="form-control" id="year" type="date" aria-label="default input example"> -->
                <label for="">Category:</label>
                <select class="form-select" id="category_id" aria-label="Default select example">
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backedit">Back</button>
                <button type="button" class="btn btn-primary" id="updatebook">Update</button>
              </div>
            `;
            $('#editmodal .modal-content').append(appendEdit);
            
            // Spread the select category, but this time, selected already
            spreadCategory(categoryid)

            $('#editmodal .modal-content #backedit').click(()=>{
              $('#editmodal .modal-content').empty()
              $('#editmodal').modal('hide')
            })

            // Show the modal
            $('#editmodal').modal('show')

            // Click event for update button
            $('#editmodal').off()
            $('#editmodal').on('click', '#updatebook', function() {
                // Retrieve the selected category value when the user clicks the update button
                let category_edit = $('#editmodal .modal-content #category_id').val();
                let title_edit = $('#editmodal .modal-content #title').val()
                let isbn_edit = $('#editmodal .modal-content #isbn').val()
                let author_edit = $('#editmodal .modal-content #author').val()
                let publisher_edit = $('#editmodal .modal-content #publisher').val()
                let book_id = $('#editmodal .modal-content #bookid').val()

                if(title_edit == "" || isbn_edit == "" || author_edit == "" || publisher_edit == "" || category_edit == "-100"){
                  $('#editerror').modal('show')
                  $('#editmodal').modal('hide')
                  $('#editerrmessage').text("Please fill-up everything.")
                }
                else if(booktitle == title_edit && bookisbn == isbn_edit && author == author_edit && publisher == publisher_edit && categoryid == category_edit){
                  $('#editmodal').modal('hide')
                  $('#editsuccess').modal('show')
                  $('#editsuccessmessage').text("Nothing was changed.")
                }
                else{
                  // Update if everything has value
                  updateBook(title_edit, isbn_edit, author_edit, publisher_edit, category_edit, book_id)
                }
            });

            // Edit validation when click OK button
            $('#editErrOk').click(()=>{
              $('#editerror').modal('hide')
              $('#editmodal').modal('show')
            })

          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Perform add
      function insertBook(title, isbn, author, publisher, category){
        var insertBook = "insertBook";
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
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
            category: function(){
              return category
            },
          },
          dataType: 'json',
          success: (r) => {
            // Flag variable
            let checkError = true;
            $.each(r, (key, val) => {
              checkError = key['IsError']
            })

            $('#addmodal').modal('hide');
            $('#modalsuccess').modal('show');

            if(checkError != true){
              $('#successmessage').text('Successfully add new book!');
            }
            else{
              $('#successmessage').text('Failed to add new book.');
            }

            $('#okMessageSuccess').click(function(){
              $('#modalsuccess').modal('hide');

              // Empty the values of the inputs add modal
              $('#title').val('')
              $('#isbn').val('')
              $('#author').val('')
              $('#publisher').val('')
              // var bookYear = $('#year').val()
              $('#category').val('-100')
              
              // Refresh the table
              refreshTable();
            })
          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Perform update
      function updateBook(title, isbn, author, publisher, category, id){
        var updateBook = "updateBook";
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
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
            category: function(){
              return category
            },
            id: function(){
              return id
            },
          },
          dataType: 'json',
          success: (r) => {
            let checkError = true;
            $.each(r, (key, val) => {
              checkError = val
            })
            $('#editmodal').modal('hide')
            if(checkError != true){
              $('#editsuccess').modal('show')
              $('#editsuccessmessage').text('Update details successfully!')
            }
            else{
              $('#editsuccess').modal('show')
              $('#editsuccessmessage').text('Failed to update details of book. Please try again.')
            }
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
          url:base_url + "controllers/BookCatalogController.class.php",
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
            let errorDelete = true
            $.each(r, (key, val) => {
              errorDelete = key['IsError']
            });

            // If error delete is false, then success
            if(errorDelete != true){
              $('#deletevalidation').modal('hide');
              $('#deletesuccess').modal('show')
              $('#deletemessage').text('Delete successfully!');
            }
            // Otherwise, failed to delete the book
            else{
              $('#deletevalidation').modal('hide');
              $('#deletesuccess').modal('show')
              $('#deletemessage').text('Failed to delete the book.');
            }

            $('#okdelete').click(function(){
              $('#deletesuccess').modal('hide')
              // Refresh the table
              refreshTable();
            })

          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      function selectToDelete(id){
        var selectToDelete = "selectToDelete";
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
          type: 'POST',
          data: {
            function_type: function(){
              return selectToDelete;
            },
            id: function(){
              return id
            },
          },
          dataType: 'json',
          success: (r) => {
            // If not null, then show the modal delete
            
            let deleteModal = 
            `
              <div class="modal-body">
                <h3 id="delvalidationmssg"></h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="canceldelete">Cancel</button>
                <button type="button" class="btn btn-danger" id="deletebook">Delete</button>
              </div>
            `

            $('#deletevalidation .modal-content').append(deleteModal)

            if(r != null && r != undefined){
              $('#deletevalidation').modal('show');
              $('#delvalidationmssg').text('Are you sure to delete this book?');
            } 

            // Cancel delete
            $('#canceldelete').click(function(){
              $('#deletevalidation .modal-content').empty()
              $('#deletevalidation').modal('hide');
            })

            // Click the delete button
            $('#deletebook').click(function(){
              deleteBook(r)
            })
          },
          error: (xhr, status, error) => {
            console.log(error)
            // const errMessage = xhr.responseText || status + ' ' + error;
          }
        })
      }

      // Function for status data tables
      function currentStatus(status){
        var currentStatus = "currentStatus";
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
          type: 'POST',
          data: {
            function_type: function(){
              return currentStatus;
            },
            status: function(){
              return status
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

      // On change function search
      function searchBook(name, status){
        var searchBook = "searchBook";
        $.ajax({
          url:base_url + "controllers/BookCatalogController.class.php",
          type: 'POST',
          data: {
            function_type: function(){
              return searchBook;
            },
            name: function(){
              return name
            },
            status: function(){
              return status
            }
          },
          dataType: 'json',
          success: (r) => {
            datatable.clear();
            datatable.rows.add(r);
            datatable.draw(false);
          },
          error: (xhr, status, error) => {
            console.log(error)
          }
        })
      } 

      function inputChange(){
        $('#search-book').change(function(){
          let bookName = $('#search-book').val()
          let status = $('#status').val()
          searchBook(bookName, status)
        })
      }
      
      // Add buttons and call function
      $('#addbook').click(function(){
        var bookTitle = $('#title').val()
        var bookISBN = $('#isbn').val()
        var bookAuthor = $('#author').val()
        var bookPublisher = $('#publisher').val()
        // var bookYear = $('#year').val()
        var bookCategory = $('#category').val()

        if(bookTitle == "" || bookISBN == "" || bookAuthor == "" ||
        bookPublisher == "" || bookCategory == "-100"){
          $('#addmodal').modal('hide');
          $('#modalerror').modal('show');
          $('#errormessage').text('Please fill-up everything.');
        }
        else{
          insertBook(bookTitle, bookISBN, bookAuthor, bookPublisher, bookCategory)
        }
      })

      // Update functions such as buttons, modal, etc
      $(document).on('click', '.edit-button', function(){
        let edit_id = $(this).data('bookid');
        if(edit_id != ""){
          selectSpecificBook(edit_id)
        }
      })


      // Delete functions such as buttons, modal, etc
      $(document).off('click', '.delete-button');
      $(document).on('click', '.delete-button', function(){
        let delete_id = $(this).data('bookid');
        if(delete_id != ""){
          // deleteBook(delete_id)
          selectToDelete(delete_id)
        }
      })

      // Refresh table thru status
      $('#status').change(function() {
        currentStatus($('#status').val());
      });

      

    })


  </script>
  <div class="container-fluid fs-2 text-center m-2">
    <div class="">Book Catalog</div>
  </div>
  
  <div class="container">

    <div class="row">
      <div class="col-md">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal">ADD</button>
      </div>
      <div class="col-md">
        <input type="text" class="form-control" id="search-book" placeholder="Search here...">
      </div>
      <div class="col-md">
        <select class="form-select" id="status" aria-label="Default select example">
          <option value="0" selected>All</option>
          <option value="1">Active</option>
          <option value="2">Deleted</option>
        </select>
      </div>
    </div>
    <!-- <div id="add" class="">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal">ADD</button>
    </div> -->
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

  <!-- SECTION MODALS - ADD -->
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
            <!-- <label for="">Date:</label>
            <input class="form-control" id="year" type="date" aria-label="default input example"> -->
            <label for="">Category:</label>
            <select class="form-select" id="category" aria-label="Default select example">
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

    <!-- SECTION MODALS - ADD - validation -->
    <div class="modal" tabindex="-1" id="modalerror">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3 id="errormessage"></h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="okMessage">Ok</button>
          </div>
        </div>
      </div>
    </div>

    <!-- SECTION MODALS - ADD - success -->
    <div class="modal" tabindex="-1" id="modalsuccess">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3 id="successmessage"></h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="okMessageSuccess">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- SECTION MODALS - ADD -->

  <!-- ---------------------------------------------------------------------------------------------------------------------- -->

  <!-- SECTION MODALS - DELETE -->
  <section>
    <div class="modal" tabindex="-1" id="deletevalidation">
      <div class="modal-dialog">
        <div class="modal-content">

        </div>
      </div>
    </div>
    <div class="modal" tabindex="-1" id="deletesuccess">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3 id="deletemessage"></h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="okdelete">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- SECTION MODALS - DELETE -->

  <!-- ---------------------------------------------------------------------------------------------------------------------- -->

  <!-- SECTION MODALS - UPDATE -->
  <section>
  <div class="modal" tabindex="-1" id="editmodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Append the edit modal here -->
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="editerror">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3 id="editerrmessage"></h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="editErrOk">Ok</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" tabindex="-1" id="editsuccess">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3 id="editsuccessmessage"></h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="editSuccessOk">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- SECTION MODALS - UPDATE -->

  <!-- ---------------------------------------------------------------------------------------------------------------------- -->

  <!-- SECTION MODALS - ERROR MESSAGES -->
  <!-- <section>
    <div class="modal" tabindex="-1" id="modalerror">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3 id="errormessage"></h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="okMessage">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!-- SECTION MODALS - ERROR MESSAGES -->

  

</body>
</html>

