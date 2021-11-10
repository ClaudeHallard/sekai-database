<?php
    session_start();
	$productID = $_POST['product_id'];
?>

<!DOCTYPE html>
<html>
   	<head>
		<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        	<title>e-com/productview</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/product.css">
	</head>
    
	<body>
		<div class="topbar">
			<a href="index.php" class="home material-icons">home</a>
		    <a href="#" class="cart material-icons">shopping_cart_checkout</a>
		</div>
		<div class="product">
			<div class="photo">
		    	Photo: placeholder
			</div>
			<!-- <?php
				// include 'init.php';
				// $connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
				// echo "I made it here";
				// $query = "SELECT * FROM product";
				// echo "I made it here";
				// $result = $connect->query($query);
				// echo "I made it here";
				// echo $result;
			?> -->
			<div class="container">
				<div class="name">
					Name: placeholder
				</div>
				<div>
					<div class="price">
						Price: placeholder
					</div>
					<div class="stock">
						Stock: placeholder
					</div>
				</div>
			</div>

			<div class="description">
		    	Description: placeholder
			</div>
		</div>
	</body>
</html>
