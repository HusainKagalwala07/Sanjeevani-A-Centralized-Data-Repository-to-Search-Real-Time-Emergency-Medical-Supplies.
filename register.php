<?php
include "connect.php";
function geocode($address){

          
            // url encode the address
          echo PHP_EOL;
            $address = urlencode($address);
           
            $new_key = urlencode("AIzaSyCYb5t1X4-RhkczYxGjqcp3M7jVt1wBipA");
            // google map geocode api url
            $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s", $address, $new_key);

            echo PHP_EOL;
            // get the json response
            $resp_json = file_get_contents($url);
            
            // decode the json
            $resp = json_decode($resp_json, true);
       
            // response status will be 'OK', if able to geocode given address 
            if($resp['status']=='OK'){

                // get the important data
                $lati = $resp['results'][0]['geometry']['location']['lat'];
                $longi = $resp['results'][0]['geometry']['location']['lng'];
                $formatted_address = $resp['results'][0]['formatted_address'];
               
                // verify if data is complete
                if($lati && $longi && $formatted_address){
                 
                    // put the data in the array
                    $data_arr = array();            
                     
                    array_push(
                        $data_arr, 
                            $lati, 
                            $longi, 
                            $formatted_address
                        );
                   
                    return $data_arr;
                     
                }else{

                    return false;
                }
                 
            }else{
                return false;
            }
        }
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sanjeevani-Register</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
	
	<style>
	:root {
  --input-padding-x: 1.5rem;
  --input-padding-y: .75rem;
}

body {
  background: #9CECFB;
  /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #0052D4, #65C7F7, #9CECFB);
  /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #0052D4, #65C7F7, #9CECFB);
  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.card-signin {
  border: 0;
  border-radius: 1rem;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.card-signin .card-title {
  margin-bottom: 2rem;
  font-weight: 300;
  font-size: 1.5rem;
}

.card-signin .card-img-left {
  width: 45%;
  /* Link to your background image using in the property below! */
  background: scroll center url('img/3.jpg');
  background-size: cover;
}

.card-signin .card-body {
  padding: 2rem;
}

.form-signin {
  width: 100%;
}

.form-signin .btn {
  font-size: 80%;
  border-radius: 5rem;
  letter-spacing: .1rem;
  font-weight: bold;
  padding: 1rem;
  transition: all 0.2s;
}

.form-label-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-label-group input {
  height: auto;
  border-radius: 2rem;
}

.form-label-group>input,
.form-label-group>label {
  padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group>label {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0;
  /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
  padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
  padding-top: calc(var(--input-padding-y) / 3);
  padding-bottom: calc(var(--input-padding-y) / 3);
  font-size: 12px;
  color: #777;
}

.btn-google {
  color: white;
  background-color: #ea4335;
}

.btn-facebook {
  color: white;
  background-color: #3b5998;
}
	</style>
  </head>
  
<body>
	
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php"><img src="img/heart.png">&nbsp;&nbsp;Sanjeevani</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
		   <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="services.php">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            
          </ul>
        </div>
      </div>
    </nav>
	
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body">
            <h5 class="card-title text-center">Register</h5>
            <form class="form-signin" name="form1" method="post">
			<div class="form-label-group">
                <input type="text" id="inputName" class="form-control" placeholder="Name" name="name" required autofocus>
                <label for="inputUserame">Name</label>
              </div>
              <div class="form-label-group">
                <input type="text" id="inputPincode" class="form-control" placeholder="Pincode" name="pincode" required autofocus >
                <label for="inputPincode">Pincode</label>
              </div>
			  <div class="form-label-group">
                <input type="text" id="inputContact" class="form-control" placeholder="Contact" name="contact" required autofocus>
                <label for="inputUserame">Contact</label>
              </div>
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
                <label for="inputEmail">Email address</label>
              </div>
             
						  <div class="form-group">
			  
			  <textarea class="form-control" rows="5" id="address" placeholder="Enter Address" name="address"></textarea><br>
			  <select class="form-control" name="city" value="" required="">
                  <option value="">Choose Your City</option>
                  <option value="Mumbai">Mumbai</option>
                  <option value="Pune">Pune</option>
                </select><br>
				<select class="form-control" name="category" value="">
                  <option value="">Choose Your Category</option>
				  <option value="5">Admin</option>
                  <option value="4">User</option>
                  <option value="1">Hospital</option>
				  <option value="2">Pharmacy</option>
				  <option value="3">Doctor</option>
				  
                </select>
			</div>

              <hr>

              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                <label for="inputPassword">Password</label>
              </div>
              
              <div class="form-label-group">
                <input type="password" id="inputConfirmPassword" class="form-control" placeholder="Password" name="cpassword" required>
                <label for="inputConfirmPassword">Confirm password</label>
              </div>

              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="submit1" value="Register">Register</button>
              <a class="d-block text-center mt-2 small" href="login.php">Sign In From Here...</a>
              <hr class="my-4">
              
            </form>
          </div>
        </div>
		<?php 
    if(isset($_POST["submit1"]))
        {


            $name = htmlentities($_POST['name'] );
            $email = htmlentities($_POST['email'] );
            $contact = htmlentities($_POST['contact'] );
            $city= htmlentities($_POST['city']);
			$pincode= htmlentities($_POST['pincode']);
            $password = htmlentities($_POST['password'] );
            $cpassword = htmlentities($_POST['cpassword'] );
            $category = htmlentities($_POST['category'] );
			
             $address_found = 0;
             $add = htmlentities($_POST['address'] );
             if (!empty($add))
              {
                try{
                  $loc = geocode($add);
                  $address_found=1;
                   }
                catch(Exception $e)
                   {
                      $address_found=0;
                   }
              }
          if ($address_found)
          {
            //$query = "INSERT INTO `registration` (name, email, password,address, city, latitude,longitute) VALUES ('$name', '$email', '$password', $loc[2],'$place','$category', 'no', '$loc[0]','$loc[1]')";
           // $response = mysqli_query($link, $query);      
             //echo "<script> alert('$loc); </script>";


           mysqli_query($link,"insert into entitydetails values('','$category','$name','$password','$email','$loc[2]','$city','$pincode','$contact','no','$loc[0]','$loc[1]')");
			
          }
  
        //if(isset($_POST["submit1"]))
       // {
            
            //mysqli_query($link,"insert into registration values('','$_POST[name]','$_POST[uname]','$_POST[contact]','$_POST[email]','$_POST[address]','$_POST[city]','$_POST[category]','$_POST[password]','$_POST[cpassword]','no')");
	?>
	<br>
	<div class=" col-lg-12 col-lg-push-3 alert alert-success"><b>Registration Successfully!</b>Wait till your account gets approved by administration</div>
	<?php
		}	
    ?>
	
      </div>
    </div>
  </div>
   <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Sanjeevani-HealthCare 2019</p>
      </div>
      <!-- /.container -->
    </footer>
	
</body>
</html>

<script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>