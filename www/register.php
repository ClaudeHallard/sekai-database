<?php
    session_start();
    //Redirect to front page if user logged in.
	if(!empty($_SESSION['user_id'])) {
		header('Location: index.php');

        //https://thedailywtf.com/articles/WellIntentioned-Destruction
        die();
	}
?>

<!DOCTYPE html>
<html>
   	<head>
		<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        	<title>e-com/productview</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/register.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>
    
	<body>
        <?php include 'menu.php'; ?>
		<!-- <div class="topbar">
			<a href="index.php" class="home material-icons">home</a>
		    <a href="#" class="cart material-icons">shopping_cart_checkout</a>
		</div><div> -->
		<div class="registerform">
			<div class="signup">SIGN UP</div>
			<form action="" id="register_form" method="post" autocomplete="off">
				<label>Email</label><br>
				<input type="text" id="Email" name="email" placeholder="Enter email" required><br>
				<label>Password</label><br>
				<input type="password" id="Password" name="password" placeholder="**********" required><br>
				<br>
				<label>First name</label><br>
				<input type="text" id="fname" name="fname" placeholder="Enter first name" required><br>
				<label>Last name</label><br>
				<input type="text" id="lname" name="lname" placeholder="Enter last name" required><br>
				<label>Phone</label><br>
				<input type="text" id="Phone" name="phone" placeholder="Enter phone number" required><br>
				<label>Address</label><br>
				<input type="text" id="Address" name="address" placeholder="Enter address" required><br>
				<label>City</label><br>
				<input type="text" id="City" name="city" placeholder="Enter city" required><br>
				<label>Postal code</label><br>
				<input type="text" id="Postalcode" name="postalcode" placeholder="Enter postalcode" required><br>
				<input type="submit" class="submit" name="SubmitButton" value="Create Account"/>
			</form>

			<?php
				if(isset($_POST['SubmitButton'])){
					if (!empty($_POST['email']) &&
                        !empty($_POST['password']) &&
						!empty($_POST['lname']) && 
						!empty($_POST['fname']) && 
						!empty($_POST['phone']) && 
						!empty($_POST['address']) && 
						!empty($_POST['city']) && 
						!empty($_POST['postalcode']))
					{
						include 'init.php';
						$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
						
						$email = mysqli_real_escape_string($connect, $_POST['email']);
						$lastName = mysqli_real_escape_string($connect, $_POST['lname']);
						$firstName = mysqli_real_escape_string($connect, $_POST['fname']);
						$phone = mysqli_real_escape_string($connect, $_POST['phone']);
						$address = mysqli_real_escape_string($connect, $_POST['address']);
						$city = mysqli_real_escape_string($connect, $_POST['city']);
						$postalcode = mysqli_real_escape_string($connect, $_POST['postalcode']);

						$password = hash("sha512", $_POST['password']);
						
						$checkPass = mysqli_query($connect, "SELECT Password FROM customer WHERE Email='$email'");
						if(mysqli_num_rows($checkPass) > 0){
							echo "<div class='error'>Account exists, please login.</div>";
						} else{
							$sql = "insert into customer (Email, Lastname, Firstname, Phone, Address, City, PostalCode, Password) values ('$email', '$lastName', '$firstName', '$phone', '$address', '$city', '$postalcode', '$password')";
					
							if (mysqli_query($connect, $sql)) {
								echo "<script>document.getElementById('register_form').innerHTML = '';</script>";
								echo "<div class='success'>Account created, you will be redirected to the login screen.</div>";
								echo "<script>setTimeout(function(){
									window.location.replace('login.php');
								 }, 5000);</script>";
							}
						}
					}
				}
			?>
		</div>
	</body>
</html>
