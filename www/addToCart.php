<html>

	<head>
		<link rel="stylesheet" href="css/addToCartStyle.css">
	</head>

<?php
	session_start();


	if(!empty($_POST['addToCart'])) {
		$productID = $_POST['addToCart'];
		/*if($productID == 1) {
			$cart = array();

		}*/
		$cart = array();
		foreach($_SESSION['cartArray'] as $value) {
			array_push($cart,$value);
		}
		array_push($cart,$productID);
		$_SESSION['cartArray'] = $cart;

	}

	$len = sizeof($_SESSION['cartArray']);
	for($i=0;$i< $len;$i++) {
		echo "<div id='productCanvas'> works" . $_SESSION['cartArray'][$i];  
		echo "</div>";

	}

	echo "<div id='tocheckout'>Checkout</div>"
?>
