<!DOCTYPE html>
<html>
<head>
  <title></title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>

<!-- Modal INSERT -->
<div class="modal fade" id="addstudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <ul class="alert alert-warning" id="saveform_errlist"></ul>
      <form id="AddEmployeeForm" method="POST" enctype="multipart/form-data">
      {{csrf_field()}}
      Title:<input type="text" name="title" class="form-control"><br>

      <div class="form-group">
        <label for="comment">Description:</label>
        <textarea class="form-control" rows="5" name="description"></textarea>
      </div><br>
  
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add_student">Save</button>
      </div>
      </form>
      </div>
     
    </div>
  </div>
</div>
<!-- Modal INSERT END-->


<!-- Modal EDIT -->
<div class="modal fade" id="Editemployeemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <input type="hidden" name="emp_id" id="emp_id">

      <form id="UpdateEmployeeForm" method="POST" enctype="multipart/form-data">
      {{csrf_field()}}

      Title:<input type="text" name="title" id="edit_title" class="form-control"><br>

      <div class="form-group">
      <label for="comment">Description:</label>
      <input type="text" name="description" id="edit_description" class="form-control"><br>
      </div><br>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add_student">UPDATE</button>
      </div>
      </form>
      </div>
     
    </div>
  </div>
</div>
<!-- Modal EDIT END-->



<!-- Modal DELETE -->
<div class="modal fade" id="DeletestudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {{csrf_field()}}
      
      <h6>Are you sure ?You want to delete this task.</h6>
      <input type="hidden" id="delete_emp_id">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="delete_modal_btn btn btn-primary add_student">Yes Delete</button>
      </div>
      </div>
     
    </div>
  </div>
</div>
<!-- Modal DELETE END-->


<div class="container">
<div class="row">
<div class="col-md-12"><br><br>
  <h4> Mercados</h4>

  <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addstudentModal"> Create Task</a>

  <div class="card-body">
   <div class="table-responsive">

   <table class="table table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>       
      </tr>
    </thead>

    <tbody>
       

    </tbody>

   </table>


   
    
   </div>
  </div>

</div>
</div>  
</div>


<script>

$(document).ready(function(){

    $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
              });

      fetchemployee();               // FETCH START
      function fetchemployee() {
        $.ajax({
            type: "GET",
            url: "/fetch-employee",
            dataType: "json",
            success: function(response) {
                // Clear the table body
                $('tbody').html("");

                // Iterate over each employee and append rows to the table
                $.each(response.employee, function(key, item) {
                    $('tbody').append('<tr>\
                        <td>' + item.id + '</td>\
                        <td>' + item.title + '</td>\
                        <td>' + item.description + '</td>\
                        <td><input type="checkbox" class="status-checkbox" data-task-id="' + item.id + '" ' + (item.status ? 'checked' : '') + '></td>\
                        <td><button type="button" value="' + item.id + '" class="edit_btn btn btn-success btn-sm">Edit</button></td>\
                        <td><button type="button" value="' + item.id + '" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
                    </tr>');
                });

                // Add event listener for checkbox changes
                $('.status-checkbox').on('change', function() {
                    var checkbox = $(this);
                    var taskId = checkbox.data('task-id');
                    var isChecked = checkbox.is(':checked');
                    var row = checkbox.closest('tr'); // Get the closest <tr> element

                  console.log('Checkbox changed: Task ID =', taskId, ', Checked =', isChecked);

                    // AJAX request to update task status
                    $.ajax({
                        url: '/tasks/update-status', // Laravel route for updating task status
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                            task_id: taskId,
                            status: isChecked ? 0 : 1
                        },
                        success: function(response) {
                            console.log('Task status updated successfully', response);

                            if (response.success) {
                            // If the task is marked as completed, fade out the row
                            if (isChecked) {
                                row.fadeOut(500, function() {
                                    // Optional: Remove the row from the DOM after fading out
                                   console.log('Row faded out and removed');
                                    row.remove();
                                });
                            }
                             } else {
                            console.error('Failed to update task status.');
                        }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error updating task status:', error);
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching employees:', error);
            }
        });
    }



    $(document).on('click', '.delete_btn', function(e){       // DELETE START
    e.preventDefault();
      
      var emp_id = $(this).val();
      $('#DeletestudentModal').modal('show');
      $('#delete_emp_id').val(emp_id);

    });

   $(document).on('click', '.delete_modal_btn', function(e){
   e.preventDefault();

   var id = $('#delete_emp_id').val();
   
   $.ajax({
   type:'DELETE',
   url:"/delete-employee/"+id,
   dataType:'json',
   success:function(response){

     if(response.status == 404)
     {
        alert(response.message);
        $('#DeletestudentModal').modal('hide');
     }
     else if(response.status == 200){
        
         fetchemployee();
        $('#DeletestudentModal').modal('hide');
        alert(response.message);
       }

     }

   });

  });




    $(document).on('click', '.edit_btn', function(e){    // EDIT START
         e.preventDefault();

         var emp_id = $(this).val();
         $('#Editemployeemodal').modal('show');
         //alert(emp_id);
         
         $.ajax({
          type:"GET",
          url: "/edit-employee/"+emp_id,
          success:function(response){
            if(response.status == 404)
            {
              alert(response.message);
              $('#Editemployeemodal').modal('hide'); 
            }
            else{

              $('#edit_title').val(response.employee.title);
              $('#edit_description').val(response.employee.description);
              $('#emp_id').val(emp_id);
            }
          }

         });

    });

  
  $(document).on('submit','#UpdateEmployeeForm', function(e){  //UPDATE START
     e.preventDefault();
     
     var id = $('#emp_id').val();
     let editformdata = new FormData($('#UpdateEmployeeForm')[0]);
     
     $.ajax({
     type:"POST",
     url:"/update-employee/"+id,
     data: editformdata,
     contentType: false,
     processData:false,
        success: function(response){
          if(response.status ==400) 
          {
                $('#update_errlist').html("");
                $('#update_errlist').addClass('alert alert-danger');
                $.each(response.errors, function(key, err_values){
                     $('#update_errlist').append('<li>'+err_values+'</li>');
                });
          }else if(response.status ==404)
          {
               alert('response.message');
          }
          else if(response.status == 200)
          {
               $('#update_errlist').html("");
               $('#update_errlist').addClass('alert alert-danger');
               $('#Editemployeemodal').modal('hide');
               alert(response.message);
               fetchemployee(); 
          }
        }
     });

  });
  

   $(document).on('submit','#AddEmployeeForm', function(e){      // INSERT START
        e.preventDefault();
        
        let formData = new FormData($('#AddEmployeeForm')[0]);

        $.ajax({

           type:'POST',
           url:'/save-employee',
           data:formData,
           dataType:'json',
           contentType:false,
           processData:false,

           success:function(response){          
              //console.log(response);

              if(response.status == 400)
              {
                $('#saveform_errlist').html("");
                $('#saveform_errlist').addClass('alert alert-danger');
                $.each(response.errors, function(key, err_values){
                     $('#saveform_errlist').append('<li>'+err_values+'</li>');
                });
              }
              else if(response.status == 200)
              {
                 $('#saveform_errlist').html("");
                 $('#saveform_errlist').addClass('alert alert-success');

                // this.reset();

                 $('#AddEmployeeForm').find('input').val("");
                 $('#addstudentModal').modal('hide')
                // $('#addstudentModal').find('input').val("");
                // fetchstudent();
                fetchemployee(); 
                alert(response.message);
              }

              
           }

        });

      });

  });
</script>



</body>
</html>