<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
	
	<!-- bootstrap Lib -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- datatable lib -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<div class="content">

	<p> Login successful </p>

	  <table id="schedule_table" class="table table-striped">  
                    <thead bgcolor="#6cd8dc">
                        <tr class="table-primary">
                           <th width="10%">Schedule ID</th>
                           <th width="10%">No. of Days</th>  
                           <th width="20%">From Date</th>
						   <th width="20%">To Date</th>
						   <th width="30%">Destination</th>
                           <th scope="col" width="5%">Show</th>
                           <th scope="col" width="5%">Edit</th>
                           <th scope="col" width="5%">Delete</th>
                        </tr>
                    </thead>
                </table>
                <br>
                <div align="right">
                <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success">Add Schedule</button>
                </div>
			
	<!-- logged in user information -->
    <?php  if (isset($_SESSION['username']) && isset($_SESSION['uid'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong> User ID: <?php echo $_SESSION['uid']; ?></p>
    <?php endif ?>
    <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>

</div>

</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="schedule_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add Schedule</h4>
                </div>
                <div class="modal-body">
                    <label>Enter No. of days</label>
                    <input type="text" name="no_of_days" id="no_of_days" class="form-control"/><br>
                    <label>Enter Start date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"/><br>
					<label>Enter End date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"/><br>
					<label>Enter City</label>
                    <input type="text" name="city" id="city" class="form-control"/><br>
                    <label>Select your interests</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="restaurant"><label> Restaurant</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="coffee"><label> Coffee</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="food"><label> Food</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="shopping"><label> Shopping</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="historic sites"><label> Historic sites</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="temple"><label> Temple</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="breakfast"><label> Breakfast</label><br>
                    <input type="checkbox" name="likes_check" class="get_value" value="lunch"><label> Lunch</label><br>
                    <input type="checkbox" name="likes_check    " class="get_value" value="dinner"><label> Dinner</label><br>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="schedule_id" id="schedule_id"/>
                    <input type="hidden" name="operation" id="operation"/>
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#add_button').click(function(){
            $('#schedule_form')[0].reset();
            $('.modal-title').text("Add Schedule Details");
            $('#action').val("Add");
            $('#operation').val("Add")
        });

     var dataTable = $('#schedule_table').DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "order": [],
        "info":true,
        "ajax":{
            url:"fetch.php",
            type:"POST"
        },
        "columnDefs":[
           {
            "target":[0,5,6],
            "orderable":false,
           },
        ],
     });

     $(document).on('submit', '#schedule_form', function(event){
        event.preventDefault();
        var s_id = $('#s_id').val();
        var no_of_days = $('#no_of_days').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var city = $('#city').val();
        // checkbox values
        var insert = [];
        $('.get_value').each(function() {
            if ($(this).is(":checked")) {
                insert.push($(this).val());
            }
        });
        insert = insert.toString();
        var fd = new FormData(this);
        fd.append('insert',insert);
        if(no_of_days != '' && start_date != '' && end_date != '' && city != '')
        {
            $.ajax({
                url:"insert.php",
                method:'POST',
                //data:new FormData(this),
                data: fd,
                contentType:false,
                processData:false,
                success:function(data)
                {
                    $('#schedule_form')[0].reset();
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            alert("Some Fields are Required");
        }
    });
    
    $(document).on('click', '.update', function(){
        var schedule_id = $(this).attr("id");
        $.ajax({
            url:"fetch_single.php",
            method:"POST",
            data:{schedule_id:schedule_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#s_id').val(data.s_id);
                $('#no_of_days').val(data.no_of_days);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $('#city').val(data.city);
                $('.modal-title').text("Edit schedule Details");
                $('#schedule_id').val(schedule_id);
                $('#action').val("Save");
                $('#operation').val("Edit");
            }
        });
    });

    $(document).on('click','.delete', function(){

        var schedule_id = $(this).attr("id");
        if(confirm("Are you sure want to delete this schedule?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{schedule_id:schedule_id},
                success:function(data)
                {
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
     });

    });
</script>

                           