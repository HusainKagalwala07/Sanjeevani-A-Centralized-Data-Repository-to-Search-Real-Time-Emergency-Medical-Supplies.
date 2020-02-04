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
          <a class="nav-link" href="admin_dashboard.php">
          
            <span>Dashboard</span>
          </a>
        </li>
		
		 <li class="nav-item active">
          <a class="nav-link" href="adminrecords.php">
          
            <span>Records</span>
          </a>
        </li>
		 <li class="nav-item active">
          <a class="nav-link" href="adminproduct.php">
          
            <span>Add Products</span>
          </a>
        </li>
		 <li class="nav-item active">
          <a class="nav-link" href="addmingraph.php">
          
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
			<div class="border-head">
              <h3>Members Records</h3>
                <form method="post">

                    <input class="form-control" type="text" placeholder="Enter Member Name" name="searchentity" required="" /><br>
                    <input type="submit" value="Find" name="find" class="btn btn-primary" />

                </form>
            </div>
			<?php
            if(isset($_POST["find"])) {
                $inputname = $_POST['searchentity'];
                $res = mysqli_query($link, "select * from entitydetails where entitydetails.name like '%$inputname%'");
                echo "<table class='table table-bordered table-striped table-condensed'>";
                echo "<tr>";
                echo "<th>";
                echo "Name";
                echo "</th>";
                echo "<th>";
                echo "Email";
                echo "</th>";
                echo "<th>";
                echo "Address";
                echo "</th>";
                echo "<th>";
                echo "City";
                echo "</th>";
                echo "<th>";
                echo "Contact";
                echo "</th>";
                echo "<th>";
                echo "Category";
                echo "</th>";
                echo "<th>";
                echo "Status";
                echo "</th>";
                echo "<th>";
                echo "Approved";
                echo "</th>";
                echo "<th>";
                echo "Not Approved";
                echo "</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row["name"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["email"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["address"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["city"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["contact"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["fktype"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["status"];
                    echo "</td>";
                    echo "<td>"; ?><a href="approved.php?id=<?php echo $row["edid"]; ?>">Approved</a><?php echo "</td>";
                    echo "<td>"; ?><a href="notapproved.php?id=<?php echo $row["edid"]; ?>">Not
                        Approved</a><?php echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
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
