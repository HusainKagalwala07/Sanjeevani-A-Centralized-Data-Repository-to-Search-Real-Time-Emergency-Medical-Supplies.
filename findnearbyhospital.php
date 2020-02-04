<?php
session_start();
include "connect.php";
$credentials=$_SESSION['identity'];
$query="SELECT * from entitydetails WHERE email = '$credentials'";
$data = mysqli_query($link,$query);
$result = mysqli_fetch_assoc($data);
//print_r($result);
$email = $result['email'];
$name = $result['name'];
$fktype = $result['fktype'];
if($credentials==true)
{
   if(isset($_POST['bloodgroup']) ){

 $count=5;
  $address= $result['address'];
 	$blood_type=  htmlentities($_POST['bloodgroup']);
 // $city=  htmlentities($_POST['city'] );
 // $quantity=  htmlentities($_POST['quantity'] );
  
  if(!empty($blood_type)){
    try{
     // $loc= geocode($address);
      $latitude=$result['latitude'];
      $longitude=$result['longitude'];
      $address_found=1;
    }catch(Exception $e){
      $address_found=0;
    }

    if($address_found){ 
			$Range = "1.1"; // e.g. 1.1 = 10% , 1.2=20% etc
			$Limit1 = "10";
			
		$query="SELECT entitydetails.edid, entitydetails.fktype, entitydetails.name, entitydetails.address, entitydetails.city, 
entitydetails.pincode, entitydetails.contact, entitydetails.latitude, entitydetails.longitude, concat('http://localhost/Project-Sanjeevani/viewstock.php?edid=', entitydetails.edid, '&bloodgroup=', '$blood_type') as URL from entitydetails WHERE fktype='1' and 
edid in (select hospid from bloodinventory join bloodgroup on bloodgroup.grpid = bloodinventory.grpid where 
bloodgroup.grpid='$_POST[bloodgroup]') and latitude <= ($latitude*$Range) AND latitude >= ($latitude/$Range) AND 
longitude <= ($longitude*$Range) AND longitude >= ($longitude/$Range) 
ORDER BY SQRT(POWER((latitude - $latitude),2)+POWER((longitude - $longitude),2)) LIMIT 0,$Limit1";
//print_r($query);
//$querydemo = "SELECT `edid`, `fktype`, `name`, `address`, `contact`,`latitude`, `longitude` FROM `entitydetails` WHERE fktype =$fktype";
$resultmap=mysqli_query($link,$query);
     
      if($resultmap ){
       
        $display=1; // For displaying tables
        $hospital_list= array();
		
  	     while($data= mysqli_fetch_assoc($resultmap)){
		 
            
          array_push( $hospital_list, $data);
         
        }
		
        $json=json_encode($hospital_list);
		
 	    }else{
			 
 		     echo "Search Failed! No Data Found.";
 	    }
    }else{
      echo "Search Failed! Invalid Address, try including city name.";
    }
  }
}

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

    <title>Sanjeevani-Hospital Panel</title>

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
          <a class="nav-link" href="bloodreports.php">
         
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
          <div>
            <div>
            <form method ="post">
			
			 <select class="form-control" name="bloodgroup" value="" required="">
                  <option value="">Choose Blood Group</option>
                  <option value="1">A+</option>
                  <option value="2">A-</option>
				  <option value="3">B+</option>
				  <option value="4">B-</option>
				  <option value="5">O+</option>
				  <option value="6">O-</option>
				  <option value="7">AB+</option>
				  <option value="8">AB-</option>
                </select><br>
              
              
              <button class="btn btn-primary" type="submit" name="submit1">Search</button>
			
			</form>
            
			
          </div>

          <!--map-->
		 
		
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
<div id="map" style="width:100%; height:100%;"></div>
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

    <!-- Page level plugin JavaScript
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>-->

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>-->
     
	  <script>
    function initialize(){
  createMap();
}
   
    function createMap(){
     var json_array=JSON.parse('<?php echo json_encode($hospital_list);?>');
  var responce=JSON.stringify(json_array);
        console.log(responce);
//        var myObject=JSON.parse(responce);
        var jsonData=JSON.parse(responce)
    var map = initMap();
        for(var i in jsonData){
            console.log(jsonData[i].latitude);
            console.log(jsonData[i].longitude);
            var title="Hospital: "+jsonData[i].name+"\nAddress: "+jsonData[i].address;
            addMarker(jsonData[i].latitude, jsonData[i].longitude, map ,title, jsonData[i].URL)
			
            }
			
        }
        
        function addMarker(latmap,lngmap, gmap , gtitle, gurl){
            var uluru = new google.maps.LatLng(latmap, lngmap);

            //{lat: latmap, lng: lngmap};
             var marker = new google.maps.Marker({
                position: uluru,
                map: gmap,
                title: gtitle,
				url:gurl
    });
	google.maps.event.addListener(marker, 'click', function() {
    window.location.href = this.url;
});
        }
        
    function initMap() {
        var uluru = {lat: <?php echo $latitude;?>, lng: <?php echo $longitude;?>};
         map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: uluru
        });
      return map;
      }
        
    </script>
      
      <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYb5t1X4-RhkczYxGjqcp3M7jVt1wBipA&callback=initialize">
    </script>

	
  </body>
</html>
