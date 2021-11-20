<!DOCTYPE html>





<html>
   	<head>
		<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        	<title>e-com/checkoutview</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/checkout.css">
	</head>
    <body>
        <div class="topbar">
			<a href="index.php" class="home material-icons">home</a>
		    <a href="#" class="cart material-icons">shopping_cart_checkout</a>
		</div>


        <div class="container1">
            <div class="personalInformation">
				<form action="" method="post">
					<label for="fname">First name:</label><br>
					<input type="text" id="fname" name="fname" placehoolder="Mandatory fill in"><br>
					<label for="lname">Last name:</label><br>
					<input type="text" id="lname" name="lname" placehoolder="Mandatory fill in"><br>
					<label for="lname">Email:</label><br>
					<input type="text" id="Email" name="email" placehoolder="Mandatory fill in"><br>
					<label for="lname">Phone:</label><br>
					<input type="text" id="Phone" name="phone"><br>
					<label for="lname">Adress:</label><br>
					<input type="text" id="Adress" name="address"><br>
					<label for="lname">City:</label><br>
					<input type="text" id="City" name="city"><br>
					<label for="lname">Postal code:</label><br>
					<input type="text" id="Postalcode" name="postalcode"><br>
					<label for="lname">Credit card number:</label><br>
					<input type="text" id="CCN" name="ccn"><br>

					<input type="submit" name="SubmitButton"/>
				</form>







				<?php
				$productID = 1;
				if(isset($_POST['SubmitButton'])){
					//Unsafe variables
					$email = $_POST['email'];
					$lastName = $_POST['lname'];
					$firstName = $_POST['fname'];
					$phone = $_POST['phone'];
					$address = $_POST['address'];
					$city = $_POST['city'];
					$postalcode = $_POST['postalcode'];
			
			
					include 'init.php';
					$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
					$checkPass = mysqli_query($connect, "SELECT Password FROM customer WHERE Email='$email'");



					if(mysqli_num_rows($checkPass) > 0){
						echo "Account exists, please login ";
					} else{
						$stmt = $connect->prepare("INSERT INTO customer (Email, Lastname, Firstname, Phone, Address, City, PostalCode) VALUES (?, ?, ?, ?, ?, ?, ?)");
						$stmt->bind_param("sssssss", $email, $lastName, $firstName, $phone, $address, $city, $postalcode);
						if ($stmt->execute()) {
							echo "Order complete";
						}
						else {
							echo "Error: " . $stmt . "<br>" . mysqli_error($connect);
						}
						$stmt->close();
					}
				}
				?>
            </div>
        </div>













	</body>













</html>