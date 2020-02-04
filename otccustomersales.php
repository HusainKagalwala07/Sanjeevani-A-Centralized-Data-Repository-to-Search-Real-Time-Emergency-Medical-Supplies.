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
$prod_id;

if($credentials==true)
{
    if(isset($_POST['prod_id']) ){

        $count=5;
        $address= $result['address'];
        global $prod_id;
        $prod_id =  htmlentities($_POST['prod_id']); ?>
        <script type="text/javascript">
            $("#productlist option").each(function(i,el) {
                data[$(el).data("value")] = $(el).val();
            });
            console.log(data, $("#productlist option").val());
            var value = $('#prod_id').val();
            var _value = $('#productlist [value="' + value + '"]').data('value');
            $prod_id = _value;
        </script>
        <?php
    }
}
else
{
    header('location:login.php');

}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
              <a class="nav-link" href="pharmacy_dashboard.php">

                  <span>Dashboard</span>
              </a>
          </li>
          <li class="nav-item active">
              <a class="nav-link" href="otcsales.php">

                  <span>Sales</span>
              </a>
          </li>
          <li class="nav-item active">
              <a class="nav-link" href="productsinventory.php">

                  <span>Products</span>
              </a>
          </li>
          <li class="nav-item active">
              <a class="nav-link" href="customersales.php">

                  <span>Customers</span>
              </a>
          </li>
          <li class="nav-item active">
              <a class="nav-link" href="suppliers.php">

                  <span>Suppliers</span>
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
                <?php
                //echo "Product Name";
                $addnewproduct = mysqli_query($link,"select * from entitydetails where entitydetails.fktype='4'");
                echo "<select class='form-control' name='newproductlist' placeholder='Select Product' value='' required=''>";

                while ($rowadd = mysqli_fetch_array($addnewproduct)){
                    $newpid = $rowadd['edid'];
                    $newpgenname = $rowadd['name'];
                    echo " <option value=$newpid>$newpgenname</option>" ;
                }
                echo "</select>";

                ?>
                <input type="submit" class="form-control btn-primary" name="viewpresc" value="View Prescription">
                <!-- </form>
            <form method="post"> -->
            <?php
            if(isset($_POST["viewpresc"]))
            {
                $patientid = $_POST['newproductlist'];
                $result1=mysqli_query($link,"select products.prod_genericname, prescription_parent.pres_id, prescription_parent.date, prescription_child.frequency, prescription_child.notes, products.price from prescription_child join products on prescription_child.prod_id = products.prod_id join prescription_parent on prescription_parent.pres_id = prescription_child.pres_id where prescription_parent.edid_patient = '$patientid' and prescription_parent.pres_id = (Select max(prescription_parent.pres_id) from prescription_parent where prescription_parent.edid_patient = '$patientid')");
                $result2 = mysqli_query($link,"select prescription_parent.pres_id, prescription_parent.date, entitydetails.name, entitydetails.contact from prescription_parent join entitydetails on prescription_parent.edid_dr = entitydetails.edid where prescription_parent.edid_patient = '$patientid' order by abs(datediff(prescription_parent.date, now())) limit 1");
                $valuesfetched = mysqli_fetch_assoc($result2);
                global $presid;
                $presid = $valuesfetched['pres_id'];
                $_SESSION['PrescriptionID'] = $valuesfetched['pres_id'];
                $date = $valuesfetched['date'];
                $drname = $valuesfetched['name'];
                $contact = $valuesfetched['contact'];
                echo "<table class='table table-bordered table-striped table-condensed'>";
                    echo "<tr>";
                    echo "<td>";echo "Prescription ID: ".$presid;echo "</td>";
                    echo "<td>";echo "Date: ".$date;echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>";echo "Doctor's Name: ".$drname;echo "</td>";
                    echo "<td>";echo "Contact: ".$contact;echo "</td>";
                    echo "</tr>";
                echo "</table>";
                $result3 = mysqli_query($link,"SELECT sum(products.price) as GTotal from products where products.prod_id in (select prescription_child.prod_id from prescription_child where prescription_child.pres_id='$presid')");
                $valuesfetched3 = mysqli_fetch_assoc($result3);
                $GTotal = $valuesfetched3['GTotal'];
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
                echo "<tr>";
                echo "<td colspan = 3>"; echo "<label>Gross Total</label>"; echo "</td>";
                echo "<td>"; echo "<input type='text' name='GTotal' id='GTotal' value='$GTotal' readonly/>"; echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan = 3>"; echo "<label>Discount %</label>"; echo "</td>";
                echo "<td>"; echo "<input type='text' name='Discount' id='Discount'/>"; echo " % </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan = 3>"; echo "<label>Tax %</label>"; echo "</td>";
                echo "<td>"; echo "<input type='text' name='Tax' id='Tax'/>"; echo " % </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan = 3>"; echo "<label>Net Total</label>"; echo "</td>";
                echo "<td>"; echo "<input type='text' name='NTotal' id='NTotal' readonly/>"; echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<input type = 'submit' name = 'sales' value = 'Sale' >";
            }

            if(isset($_POST["sales"])){
                $GTotalP = $_POST['GTotal'];
                $DiscountP = htmlentities($_POST['Discount']);
                $TaxP = htmlentities($_POST['Tax']);
                $NTotalP = htmlentities($_POST['NTotal']);
                $presid = $_SESSION['PrescriptionID'];
                mysqli_query($link,"INSERT INTO `sales`( `edid`, `pres_id`, `gtotal`, `discount`, `tax`, `ntotal`) VALUES ('$edid','$presid','$GTotalP','$DiscountP','$TaxP','$NTotalP')");
                }
            ?>
            </form>
        </div>
        <script>
            $(function () {
                $("#Discount, #Tax").keyup(function () {

                    var GTafterDisc = +$("#GTotal").val() - (+$("#GTotal").val()* +$("#Discount").val()/100);
                    var TaxCalc = GTafterDisc * +$("#Tax").val()/100;
                    var NTafterTax = GTafterDisc + TaxCalc;
                    $("#NTotal").val(Number(NTafterTax).toFixed(2));
                });
            });

        </script>
        <script type="text/javascript">
            function redir() {
                window.location = "sales.php?presid=<?php echo $presid ;?>";
            }
        </script>





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
