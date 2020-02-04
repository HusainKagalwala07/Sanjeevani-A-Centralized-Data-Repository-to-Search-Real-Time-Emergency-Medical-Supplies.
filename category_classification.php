<?php

session_start();
include "connect.php";
$credentials=$_SESSION['identity'];
$query="SELECT * from entitydetails WHERE email = '$credentials'";
$data = mysqli_query($link,$query);
$result = mysqli_fetch_assoc($data);
$fktype = $result['fktype'];

if($fktype == '1')
{
	?>
	
	<script type="text/javascript">
	window.location="hospital_dashboard.php";
    </script>
<?php 
	
}
 
 else if($fktype == '2')
 {
	 ?>
	 
	 <script type="text/javascript">
	window.location="pharmacy_dashboard.php";
    </script>
<?php 
	 
 }
 
 else if($fktype == '3')
 {
	 ?>
	 
	 <script type="text/javascript">
	window.location="doctor_dashboard.php";
    </script>
<?php 

	 
 }
 
 else if($fktype == '4')
 {
	 ?>
	 
	 <script type="text/javascript">
	window.location="user_dashboard.php";
    </script>
<?php 
	 
 }

 else if($fktype == '5')
 {
	 ?>
	 
	 <script type="text/javascript">
	window.location="admin_dashboard.php";
    </script>
<?php 
	 
 }
 
?>
