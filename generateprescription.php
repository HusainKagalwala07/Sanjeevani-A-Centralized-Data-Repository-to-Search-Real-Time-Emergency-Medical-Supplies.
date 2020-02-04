<!--
//index.php
!-->
<?php
session_start(); include 'connect.php';
$credentials=$_SESSION['identity'];
$queryS="SELECT * from entitydetails WHERE email = '$credentials'";
$data = mysqli_query($link,$queryS);
$result = mysqli_fetch_assoc($data);
$email = $result['email'];
$name = $result['name'];
$edid = $result['edid'];
if($credentials==true)
{
	
}
else
{
	header('location:login.php');
	
}
?>
<html>  
    <head> 


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sanjeevani-Doctor Panel</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

 	
        <title>Sanjeevani-Doctor Panel</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
 

 <body>   <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand" href="index.php"><img src="img/heart.png">&nbsp;&nbsp;Sanjeevani</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        
      </form>

      <!-- Navbar -->
     <ul class="navbar-nav ml-auto ml-md-0">
        
        
        <li class="nav-item dropdown no-arrow">
      
            <span><font color="white"><a data-toggle="modal" data-target="#logoutModal"><?php echo "Logout ".$credentials;?></a></font></span>
        </li>
      </ul>

    </nav>
	<div id="wrapper">

      <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="doctor_dashboard.php">
          
            <span>Dashboard</span>
          </a>
        </li>
		<li class="nav-item active">
          <a class="nav-link" href="patientrecords.php">
           
            <span>Patient Records</span>
          </a>
        </li>
		
		
		<li class="nav-item active">
          <a class="nav-link" href="prescribedrug.php">
            
            <span>Prescribe Drugs</span>
          </a>
        </li>
        
        
      </ul>
        
   <br />
   <div class= 'container'>
   <h3 align="center">Generate Prescription</a></h3><br />
   <br />
   <br />
   <div align="right" style="margin-bottom:5px;">
    <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
   </div>
   <br />
   <form method="post" id="user_form">
    <div class="table-responsive">
     <table class="table table-striped table-bordered" id="user_data">
      <tr>
       <th>Product Name</th>
       <th>Frequency</th>
	   <th>Notes</th>
       <th>Details</th>
       <th>Remove</th>
      </tr>
     </table>
    </div>
    <div align="center">
     <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Insert" />
    </div>
   </form>

   <br />
   </div>
  </div>
  <div id="user_dialog" title="Add Data">
   <div class="form-group">
    <label>Enter Product Name</label>
	<?php
//echo "Product Name";
		 $res1 = mysqli_query($link,"Select * from products");
		 echo "<input list ='productlist' name='first_name' id='first_name' class='form-control' required=''>";
		 echo "<datalist id='productlist'>";
			while ($row1 = mysqli_fetch_array($res1)){
				
                                echo "<option data-value='". $row1['prod_id'] ."' value='" .$row1['prod_genericname'] ."'></option>" ;
                            }
							echo "</datalist>";
                            	
	?>
    <!-- <input type="text" name="first_name" id="first_name" class="form-control" list="ProductList" /> -->
    <span id="error_first_name" class="text-danger"></span>
   </div>
   <div class="form-group">
    <label>Enter Frequency</label>
    <input type="text" name="last_name" id="last_name" class="form-control" />
    <span id="error_last_name" class="text-danger"></span>
   </div><div class="form-group">
    <label>Enter Notes</label>
    <input type="text" name="middle_name" id="middle_name" class="form-control" />
    <span id="error_last_name" class="text-danger"></span>
   </div>
   <div class="form-group" align="center">
    <input type="hidden" name="row_id" id="hidden_row_id" />
    <button type="button" name="save" id="save" class="btn btn-info">Save</button>
   </div>
  </div>
  <div id="action_alert" title="Action">

  </div>
  <footer class="sticky-footer py-5 bg-dark">
          <div class="container my-auto">
            <div class="m-0 text-center text-white">
              <span>Copyright &copy; Sanjeevani-HealthCare 2019</span>
            </div>
          </div>
        </footer>
		
    </body>  
</html> 

<script>  

$(document).ready(function(){ 
 
 var count = 0;

 $('#user_dialog').dialog({
  autoOpen:false,
  width:400
 });

 $('#add').click(function(){
  $('#user_dialog').dialog('option', 'title', 'Add Data');
  $('#first_name').val('');
  $('#last_name').val('');
  $('#middle_name').val('');
  $('#error_first_name').text('');
  $('#error_last_name').text('');
  $('#first_name').css('border-color', '');
  $('#last_name').css('border-color', '');
  $('#save').text('Save');
  $('#user_dialog').dialog('open');
 });

 $('#save').click(function(){
  var error_first_name = '';
  var error_last_name = '';
  var first_name = '';
  var last_name = '';
  var middle_name = '';
  var data = {};
$("#productlist option").each(function(i,el) {  
   data[$(el).data("value")] = $(el).val();
});
console.log(data, $("#productlist option").val());
var value = $('#first_name').val();
var _value = $('#productlist [value="' + value + '"]').data('value');
  if($('#first_name').val() == '')
  {
   error_first_name = 'First Name is required';
   $('#error_first_name').text(error_first_name);
   $('#first_name').css('border-color', '#cc0000');
   first_name = '';
  }
  else
  {
   error_first_name = '';
   $('#error_first_name').text(error_first_name);
   $('#first_name').css('border-color', '');
   first_name = _value;
   middle_name = $('#middle_name').val();
  } 
  if($('#last_name').val() == '')
  {
   error_last_name = 'Last Name is required';
   $('#error_last_name').text(error_last_name);
   $('#last_name').css('border-color', '#cc0000');
   last_name = '';
  }
  else
  {
   error_last_name = '';
   $('#error_last_name').text(error_last_name);
   $('#last_name').css('border-color', '');
   last_name = $('#last_name').val();
  }
  if(error_first_name != '' || error_last_name != '')
  {
   return false;
  }
  else
  {
   if($('#save').text() == 'Save')
   {
    count = count + 1;
    output = '<tr id="row_'+count+'">';
    output += '<td>'+$('#first_name').val()+' <input type="hidden" name="hidden_first_name[]" id="first_name'+count+'" class="first_name" value="'+first_name+'" /></td>';
    output += '<td>'+last_name+' <input type="hidden" name="hidden_last_name[]" id="last_name'+count+'" value="'+last_name+'" /></td>';
	output += '<td>'+middle_name+' <input type="hidden" name="hidden_middle_name[]" id="middle_name'+count+'" value="'+middle_name+'" /></td>';
    output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+count+'">View</button></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
    output += '</tr>';
    $('#user_data').append(output);
   }
   else
   {
    var row_id = $('#hidden_row_id').val();
    output = '<td>'+first_name+' <input type="hidden" name="hidden_first_name[]" id="first_name'+row_id+'" class="first_name" value="'+first_name+'" /></td>';
    output += '<td>'+last_name+' <input type="hidden" name="hidden_last_name[]" id="last_name'+row_id+'" value="'+last_name+'" /></td>';
    output += '<td>'+middle_name+' <input type="hidden" name="hidden_middle_name[]" id="middle_name'+count+'" value="'+middle_name+'" /></td>';
	output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+row_id+'">View</button></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+row_id+'">Remove</button></td>';
    $('#row_'+row_id+'').html(output);
   }

   $('#user_dialog').dialog('close');
  }
 });

 $(document).on('click', '.view_details', function(){
  var row_id = $(this).attr("id");
  var first_name = $('#first_name'+row_id+'').val();
  var last_name = $('#last_name'+row_id+'').val();
  var middle_name = $('#middle_name'+row_id+'').val();
  $('#first_name').val(first_name);
  $('#last_name').val(last_name);
  $('#middles_name').val(middle_name);
  $('#save').text('Edit');
  $('#hidden_row_id').val(row_id);
  $('#user_dialog').dialog('option', 'title', 'Edit Data');
  $('#user_dialog').dialog('open');
 });

 $(document).on('click', '.remove_details', function(){
  var row_id = $(this).attr("id");
  if(confirm("Are you sure you want to remove this row data?"))
  {
   $('#row_'+row_id+'').remove();
  }
  else
  {
   return false;
  }
 });

 $('#action_alert').dialog({
  autoOpen:false
 });

 $('#user_form').on('submit', function(event){
  event.preventDefault();
  var count_data = 0;
  $('.first_name').each(function(){
   count_data = count_data + 1;
  });
  if(count_data > 0)
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#user_data').find("tr:gt(0)").remove();
     $('#action_alert').html('<p>Data Inserted Successfully</p>');
     $('#action_alert').dialog('open');
	 //window.location = "insert.php?a="+form_data;
        window.location = "prescribedrug.php";
    }
   })
  }
  else
  {
   $('#action_alert').html('<p>Please Add atleast one data</p>');
   $('#action_alert').dialog('open');
  }
 });
 
});  
</script>
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
	

	