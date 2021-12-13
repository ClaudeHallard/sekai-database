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
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        	<title>e-com/productview</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/product.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>
    
	<body>
		<?php include 'menu.php'; ?>
		<!-- <div class="topbar">
			<a href="index.php" class="home material-icons">home</a>
		    <a href="#" class="cart material-icons">shopping_cart_checkout</a>
		</div> -->
		<div class="product">
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
				$product_URL = $product[5];
				
			?>
			<div class="photo">
				<?php echo "<img src='$product_URL' alt='image of the product'/>"; ?>
			</div>
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
			
			<div class="addProdButton">
				Add to cart
			</div>
		</div>
		<!--
		<div class="checkButtonion">
		<a href="checkout_view.php">Checkout</a>
		</div>	
			-->
	</body>
</html>
