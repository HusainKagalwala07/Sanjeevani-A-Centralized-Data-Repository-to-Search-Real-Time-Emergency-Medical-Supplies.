<?php
session_start();
include "connect.php";
$credentials=$_SESSION['identity'];
$query="SELECT * from entitydetails WHERE email = '$credentials'";
$data = mysqli_query($link,$query);
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
          <a class="nav-link" href="user_dashboard.php">
          
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="findnearbyhospital_user.php">
           
            <span>Nearby Blood-Banks</span>
          </a>
        </li>
		<li class="nav-item active">
          <a class="nav-link" href="findnearbypharmacy.php">
           
            <span>Nearby Pharmacies</span>
          </a>
        </li>
		
		<li class="nav-item active">
          <a class="nav-link" href="callingdoctor.php">
           
            <span>Calling Facility</span>
          </a>
        </li>
		
        <li class="nav-item active">
          <a class="nav-link" href="substitutemedicine.php">
           
            <span>Substitute Medicines</span>
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
		  <?php
		  $edid= $_GET['edid'];
		  $queryfetch="SELECT * from entitydetails WHERE edid = '$edid'";
			$datafetch = mysqli_query($link,$queryfetch);
				$resultfetch = mysqli_fetch_assoc($datafetch);
				 $name = $resultfetch['name'];
				 $addressfetch = $resultfetch['address'];
				 $contactfetch = $resultfetch['contact'];
				  //$cityfetch = $resultfetch['city'];
				   //$pincodefetch= $resultfetch['pincode'];
		  ?>
			<div class="border-head">
              <h3>Stock Details</h3><br>
			  <h5>Name :<?php echo "$name";?></h5>
			  <h5>Address:&nbsp;<?php echo "$addressfetch";?></h5>
			  <h5>Contact :<?php echo "$contactfetch";?></h5>
			   
            </div>
			<?php
		  $edid = $_GET['edid'];
		  $prodid = $_GET['productname'];
		  
		  $res=mysqli_query($link,"select products.prod_genericname as ProductName, stock.quantity as qty from products join stock on products.prod_id=stock.prod_id join entitydetails on entitydetails.edid=stock.phar_id where entitydetails.edid=$edid ORDER BY CASE products.prod_genericname
  WHEN '$prodid' THEN 1
  ELSE 2 END");
		  //$res1=mysqli_query($link,"select * from entitydetails where edid=$edid");
		  
		  echo "<table class='table table-bordered table-striped table-condensed'>";
		  echo "<tr>";
		  echo "<th>";echo "Products";echo "</th>";
		  echo "<th>";echo "Quantity";echo "</th>";
		  
		  echo "</tr>";
		  
		  while($row=mysqli_fetch_assoc($res))
		  {
	      echo "<tr>";
		  echo "<td>";echo $row["ProductName"];echo "</td>";
		  echo "<td>";echo $row["qty"];echo "</td>";
		  
		  echo "</tr>";
		  }
		  echo "</table>";
			
        ?>		
			
        </div>
       
	   
	   
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
