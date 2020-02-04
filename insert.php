<?php

//insert.php
session_start();
include 'connect.php';
$connect = new PDO("mysql:host=localhost;dbname=project-sanjeevani", "root", "");
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
$getpresid = "select max(pres_id) as Pres_id from prescription_parent where edid_dr = $edid";
$datapid = mysqli_query($link,$getpresid);
$result1 = mysqli_fetch_assoc($datapid);
//print_r ($result1);
$PresID = $result1['Pres_id'];
$query = "
INSERT INTO prescription_child 
(pres_id, prod_id, frequency, notes) 
VALUES (:presid, :prodid, :frequency, :notes)
";
//echo "Prescription ID: ".$_GET['PresID'];
for($count = 0; $count<count($_POST['hidden_first_name']); $count++)
{
 $data = array(
  ':presid' => $PresID,
  ':prodid' => $_POST['hidden_first_name'][$count],
  ':frequency' => $_POST['hidden_last_name'][$count],
  ':notes' => $_POST['hidden_middle_name'][$count]
 );
 $statement = $connect->prepare($query);
 $statement->execute($data);
}

?>