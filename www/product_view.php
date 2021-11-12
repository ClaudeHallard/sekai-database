<?php
    session_start();

	$productID = 1;
	if(!empty($_POST['product_id'])) {
		$productID = $_POST['product_id'];
	}
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
			<?php
				include 'init.php';
				$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
				$connect->set_charset("utf8");
				$query = "SELECT * FROM product WHERE product_ID = '$productID'";
				if(!$result = $connect->query($query)) {
					die('Error query');
				}
				$product = $result->fetch_row();

				$product_name = $product[1];
				$product_stock = $product[2];
				$product_description = $product[3];
				$product_price = $product[4];
				
			?>
			<div class="container">
				<div class="name">
					<p><?php echo $product_name ?></p>
				</div>
				<div>
					<div class="price">
						Price: <?php echo $product_price . " kr" ?>
					</div>
					<div class="stock">
						Stock: <?php echo $product_stock . " st" ?>
					</div>
				</div>
			</div>

			<div class="description">
				<?php echo "<p>$product_description</p>" ?>
			</div>
		</div>
	</body>
</html>
