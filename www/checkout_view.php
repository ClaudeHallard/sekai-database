<!DOCTYPE html>

<html>
<head>
		<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<title>e-com/checkoutview</title>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/checkout.css">
		<link rel="stylesheet" href="css/menu.css">
</head>
    <body>

<?php
	include 'init.php';
	session_start();
	include 'menu.php';
	$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
	$tempFname ="";
	$tempLname ="";
	$tempEmail ="";
	$tempPhone ="";
	$tempAdress ="";
	$tempCity = "";
	$tempPostal ="";

	if(!empty($_SESSION['user_id'])){
		$grab0 = "SELECT * FROM customer WHERE CustomerID='$_SESSION[user_id]'";
		$result = $connect->query($grab0);
		$row = $result->fetch_assoc();
		$tempFname = $row['FirstName'];
		$tempLname = $row['LastName'];
		$tempEmail = $row['Email'];
		$tempPhone = $row['Phone'];
		$tempAdress =$row['Address'];
		$tempCity = $row['City'];
		$tempPostal = $row['PostalCode'];
	}
	$tempPrice = 0;
	$totalAmount = 0;
	foreach($_SESSION['cartArray'] as $eProductID => $amountP){
		$grab = "SELECT Price FROM product WHERE Product_ID='$eProductID'";
		$tempGrabResult = mysqli_query($connect, $grab);
		$row1 = $tempGrabResult->fetch_assoc();
		$tempPrice = $amountP * $row1['Price'];
		$totalAmount = $totalAmount + $tempPrice;
	}
?>

        <div class="checkoutform">
            <div class="checkout">Total amount: <?php echo $totalAmount; ?> kr</div>
				<form action="" method="post" autocomplete="off">
					<label for="fname">First name:</label><br>
					<input type="text" id="fname" name="fname" placehoolder="Mandatory fill in" value="<?php echo "$tempFname";?>"><br>
					<label for="lname">Last name:</label><br>
					<input type="text" id="lname" name="lname" placehoolder="Mandatory fill in" value="<?php echo "$tempLname";?>"><br>
					<label for="lname">Email:</label><br>
					<input type="text" id="Email" name="email" placehoolder="Mandatory fill in" value="<?php echo "$tempEmail";?>"><br>
					<label for="lname">Phone:</label><br>
					<input type="text" id="Phone" name="phone" value="<?php echo "$tempPhone";?>"><br>
					<label for="lname">Adress:</label><br>
					<input type="text" id="Adress" name="address" value="<?php echo "$tempAdress";?>"><br>
					<label for="lname">City:</label><br>
					<input type="text" id="City" name="city" value="<?php echo "$tempCity";?>"><br>
					<label for="lname">Postal code:</label><br>
					<input type="text" id="Postalcode" name="postalcode" value="<?php echo "$tempPostal";?>"><br>
					<label for="lname">Credit card number:</label><br>
					<input type="text" id="CCN" name="ccn" value=""><br>

					<input type="submit" class="submit" name="SubmitButton" value="Execute order"/>
				</form>

				<?php

				function cartToOrder($connect, $customerID){
					$date = date("Y/m/d");
					$notDelivered = 0;
					// INSERT in i product_order (PRODUCT)
					$stmt1 = "INSERT INTO product_order (Customer_ID, OrderDate, isDelivered) VALUES ('".$customerID."', '$date', '$notDelivered')";
					$returnOpt = mysqli_query($connect, $stmt1);
		
					// GET order_ID 
					$grab = "SELECT * FROM product_order WHERE Customer_ID='$customerID'";
					mysqli_query($connect, $grab);

					$result = $connect->query($grab);
					if($result->num_rows > 0){
						While($row = $result->fetch_assoc()){
							foreach($_SESSION['cartArray'] as $eProductID => $amountP){
								$grab = "SELECT Price FROM product WHERE Product_ID='$eProductID'";
								$tempGrabResult = mysqli_query($connect, $grab);
								$row1 = $tempGrabResult->fetch_assoc();
								                                                                                                                          								
								//https://www.php.net/manual/en/mysqli.begin-transaction.php
								mysqli_begin_transaction($connect);
								try{
									$stmtCheck = "SELECT * FROM ordered_product WHERE Product_ID='$eProductID' AND Order_ID='$row[Order_ID]'";
									$checkExistence = mysqli_query($connect, $stmtCheck);
									$stmtUpd = "UPDATE ordered_product SET Amount = Amount + $amountP WHERE Product_ID='$eProductID' AND Order_ID='$row[Order_ID]' ";
									if($checkExistence->num_rows > 0){
										mysqli_query($connect, $stmtUpd);
									}
									else{
										$removeStock = "UPDATE product SET Stock = Stock - $amountP WHERE Product_ID='$eProductID'";
										mysqli_query($connect, $removeStock);
										$stmt2 = "INSERT INTO ordered_product (Order_ID, Product_ID, Amount, Price) VALUES ('$row[Order_ID]', '$eProductID', '$amountP', '$row1[Price]')";
										$checking = mysqli_query($connect, $stmt2);
									}

									mysqli_commit($connect);
								} catch(mysqli_sql_exception $exception){
									mysqli_rollback($connect);
									throw $exception;
								} 
							} 
						}
					}
					return $returnOpt;
				} 

				$productID = 1;
				if(isset($_POST['SubmitButton']) && !empty($_SESSION['cartArray'])){
					//Unsafe variables
					$email = $_POST['email'];
					$lastName = $_POST['lname'];
					$firstName = $_POST['fname'];
					$phone = $_POST['phone'];
					$address = $_POST['address'];
					$city = $_POST['city'];
					$postalcode = $_POST['postalcode'];
			
					// If there already is an inlogged user: add his cart
					if(!empty($_SESSION['user_id'])){
						echo (cartToOrder($connect, $_SESSION['user_id'])) ? "Order complete" : "Order failed";
					}								
					else{
						// Check if guest customer has account
						$stmt = $connect->prepare("SELECT Password FROM customer WHERE Email=?");
						$stmt->bind_param("s", $email);
						$stmt->execute();
						$result = $stmt->get_result();
						if(mysqli_num_rows($result) > 0){
							echo "Account exists, please login ";
						} else{
							$stmt0 = $connect->prepare("INSERT INTO customer (Email, LastName, FirstName, Phone, Address, City, PostalCode) VALUES (?, ?, ?, ?, ?, ?, ?)");
							$stmt0->bind_param("sssssss", $email, $lastName, $firstName, $phone, $address, $city, $postalcode);
							$stmt0->execute();
							$stmt1 = $connect->prepare("SELECT CustomerID FROM customer WHERE Email=?");
							$stmt1->bind_param("s", $email);
							$stmt1->execute();
							$result1 = $stmt1->get_result();
							$tempArray = $result1->fetch_assoc();
							$guestCustomerID = $tempArray['CustomerID'];
							if (cartToOrder($connect, $guestCustomerID)) {
								echo "Order complete";
							}
							else {
								echo "Order faileddddddd";
							}
						}
					}
				}	
				?>
        </div>
	</body>
</html>