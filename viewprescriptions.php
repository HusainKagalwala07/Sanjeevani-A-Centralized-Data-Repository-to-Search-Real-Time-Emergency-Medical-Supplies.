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
		
		<li class="nav-item active">
          <a class="nav-link" href="viewprescriptions.php">
           
            <span>View Previous History</span>
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
            <form method="post">
                <label>Add Patient</label>
                <?php

                $addnewproduct = mysqli_query($link,"select prescription_parent.pres_id as pid from prescription_parent where prescription_parent.edid_patient = $edid order by prescription_parent.pres_id desc");
                echo "<select class='form-control' name='newproductlist' placeholder='Select Product' value='' required=''>";

                while ($rowadd = mysqli_fetch_array($addnewproduct)){
                    $newpid = $rowadd['pid'];

                    echo " <option value=$newpid>$newpid</option>" ;
                }
                echo "</select>";

                ?>



                <button type ="submit" name="verify" value="View Prescription" class="btn btn-info">View Prescription</button>
                <button type ="submit" name="verify1" value="View Invoice" class="btn btn-info">View Invoice</button>


                <?php

                if(isset($_POST["verify"]))
                {
                    $patientid = $_POST['newproductlist'];
                    $result1=mysqli_query($link,"select products.prod_genericname, prescription_parent.pres_id, prescription_parent.date, prescription_child.frequency, prescription_child.notes, products.price from prescription_child join products on prescription_child.prod_id = products.prod_id join prescription_parent on prescription_parent.pres_id = prescription_child.pres_id where prescription_parent.edid_patient = '$edid' and prescription_parent.pres_id = $patientid");
                    $result2 = mysqli_query($link,"select prescription_parent.pres_id, prescription_parent.date, entitydetails.name, entitydetails.contact from prescription_parent join entitydetails on prescription_parent.edid_dr = entitydetails.edid where prescription_parent.edid_patient = '$edid'and prescription_parent.pres_id='$patientid'");
                    $valuesfetched = mysqli_fetch_assoc($result2);
                    $date = $valuesfetched['date'];
                    $drname = $valuesfetched['name'];
                    $contact = $valuesfetched['contact'];
                    //$valuesfetched3 = mysqli_fetch_assoc($result1);
                    //$GTotal = $valuesfetched3['GTotal'];
                    echo "<table class='table table-bordered table-striped table-condensed'>";
                    echo "<tr>";
                    echo "<th>";echo "Date";echo "</th>";
                    echo "<th>";echo "Dr. Name";echo "</th>";
                    echo "<th>";echo "Contact";echo "</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>";echo $date;echo "</td>";
                    echo "<td>";echo $drname;echo "</td>";
                    echo "<td>";echo $contact;echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "<table class='table table-bordered table-striped table-condensed'>";
                    echo "<tr>";
                    echo "<th>";echo "Product Name";echo "</th>";
                    echo "<th>";echo "Frequency";echo "</th>";
                    echo "<th>";echo "Notes";echo "</th>";
                    echo "<th>";echo "Price";echo "</th>";
                    echo "</tr>";
                    while($row=mysqli_fetch_array($result1))
                    {

                        echo "<tr>";
                        echo "<td>";echo $row["prod_genericname"];echo "</td>";
                        echo "<td>";echo $row["frequency"];echo "</td>";
                        echo "<td>";echo $row["notes"];echo "</td>";
                        echo "<td>";echo $row["price"];echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                }
                if(isset($_POST["verify1"])) {
                    $patientid = $_POST['newproductlist'];
                    $result1 = mysqli_query($link, "select products.prod_genericname, prescription_parent.pres_id, prescription_parent.date, prescription_child.frequency, prescription_child.notes, products.price from prescription_child join products on prescription_child.prod_id = products.prod_id join prescription_parent on prescription_parent.pres_id = prescription_child.pres_id where prescription_parent.edid_patient = '$edid' and prescription_parent.pres_id = $patientid");
                    $result2 = mysqli_query($link, "select sales.sales_id, entitydetails.name, entitydetails.contact, prescription_parent.date from entitydetails join prescription_parent on entitydetails.edid = prescription_parent.edid_dr join sales on sales.edid = entitydetails.edid where sales.pres_id = '$patientid' order by sales.pres_id limit 1");
                    $valuesfetched = mysqli_fetch_assoc($result2);
                    $saleid = $valuesfetched['sales_id'];
                    $date = $valuesfetched['date'];
                    $drname = $valuesfetched['name'];
                    $contact = $valuesfetched['contact'];
                    //$valuesfetched3 = mysqli_fetch_assoc($result1);
                    //$GTotal = $valuesfetched3['GTotal'];
                    echo "<table class='table table-bordered table-striped table-condensed'>";
                    echo "<tr>";
                    echo "<th>";
                    echo "Sales ID";
                    echo "</th>";
                    echo "<th>";
                    echo "Date";
                    echo "</th>";
                    echo "<th>";
                    echo "Pharmacy Name";
                    echo "</th>";
                    echo "<th>";
                    echo "Contact";
                    echo "</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>";
                    echo $saleid;
                    echo "</td>";
                    echo "<td>";
                    echo $date;
                    echo "</td>";
                    echo "<td>";
                    echo $drname;
                    echo "</td>";
                    echo "<td>";
                    echo $contact;
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "<table class='table table-bordered table-striped table-condensed'>";
                    echo "<tr>";
                    echo "<th>";
                    echo "Product Name";
                    echo "</th>";
                    echo "<th>";
                    echo "Frequency";
                    echo "</th>";
                    echo "<th>";
                    echo "Notes";
                    echo "</th>";
                    echo "<th>";
                    echo "Price";
                    echo "</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_array($result1)) {

                        echo "<tr>";
                        echo "<td>";
                        echo $row["prod_genericname"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["frequency"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["notes"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["price"];
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    $result3 = mysqli_query($link, "select * from sales where sales.sales_id = '$saleid' order by sales.pres_id limit 1");
                    $valuesfetched3 = mysqli_fetch_assoc($result3);
                    $gtotal = $valuesfetched3['gtotal'];
                    $discount = $valuesfetched3['discount'];
                    $tax = $valuesfetched3['tax'];
                    $ntotal = $valuesfetched3['ntotal'];
                    echo "<table class='table table-bordered table-striped table-condensed'>";
                    echo "<tr>";
                    echo "<th>";
                    echo "Gross Total";
                    echo "</th>";
                    echo "<th>";
                    echo "Discount %";
                    echo "</th>";
                    echo "<th>";
                    echo "Tax %";
                    echo "</th>";
                    echo "<th>";
                    echo "Net Total";
                    echo "</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>";
                    echo $gtotal;
                    echo "</td>";
                    echo "<td>";
                    echo $discount;
                    echo "</td>";
                    echo "<td>";
                    echo $tax;
                    echo "</td>";
                    echo "<td>";
                    echo $ntotal;
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                }
                ?>




            </form>
        </div>




      

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
