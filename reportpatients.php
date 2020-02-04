<?php
session_start();
include "connect.php";
$credentials=$_SESSION['identity'];
$query="SELECT * from entitydetails WHERE email = '$credentials'";
$data = mysqli_query($link,$query);
$result = mysqli_fetch_assoc($data);
$email = $result['email'];
$name = $result['name'];
if($credentials==true)
{
	
}
else
{
	header('location:login.php');
	
}
?>

<!DOCTYPE html>
<html lang="en">

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
	 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

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
          <a class="nav-link" href="hospital_dashboard.php">
           
            <span>Dashboard</span>
          </a>
        </li>
		
		<li class="nav-item active">
          <a class="nav-link" href="blood_inventory.php">
          
            <span>Blood Inventories</span>
          </a>
        </li>
		
		<li class="nav-item active">
          <a class="nav-link" href="findnearbyhospital.php">
           
            <span>Nearby Hospitals</span>
          </a>
        </li>
		
		<li class="nav-item active">
          <a class="nav-link" href="reportpatients.php">
         
            <span>Reports</span>
            
          </a>
        </li>
        
        
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              Welcome <?php echo "$name";?>
            </li>
           
          </ol>

          <!-- Icon Cards-->
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
             
           <?php 
//index.php
$connect1 = mysqli_connect("localhost", "root", "", "sanjeevani_database");
$query1 = "SELECT entitydetails.name,entitydetails.email,entitydetails.contact,patient.date, entitydetails.address from entitydetails as m join patient on entitydetails.edid=patient.edidpatient where patient.ediddoctor=$edid as s";
$result1 = mysqli_query($connect1, $query1);
$chart_data = '';
while($row = mysqli_fetch_array($result1))
{
 $chart_data .= "{ SalesMonth:'".$row["m"]."', TotalSales:".$row["s"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);
?>
             <div class="container" style="width:900px;">
  
   <h3 align="center">Monthly Patient Graph</h3>   
   <br /><br />
   <div id="chart"></div>
  </div>
  
  <script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'SalesMonth',
 ykeys:[ 'TotalSales'],
 labels:['Availability of blood Quantity'],
 hideHover:'auto',
 stacked:true
});
</script>
            
          </div>

          


        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer py-5 bg-dark">
          <div class="container my-auto">
            <div class="m-0 text-center text-white">
              <span>Copyright &copy; Sanjeevani-HealthCare 2019</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>

  </body>

</html>
