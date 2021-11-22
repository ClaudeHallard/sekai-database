<html>

	<head>
		<link rel="stylesheet" href="css/addToCartStyle.css">
	</head>

<?php
	session_start();

	include 'init.php';
	$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
	$IDs = "";
	if(!empty($_POST['addToCart'])) {
		$productID = $connect->real_escape_string($_POST['addToCart']);

		$cart = array();
		$IDs = "('";
		foreach($_SESSION['cartArray'] as $value) {
			array_push($cart,$value);
			$IDs .= $value . "','";
		}
		array_push($cart,$productID);
		$IDs .= $productID . "')";
		$_SESSION['cartArray'] = $cart;

	}
	
	
	$query = "select * from product where Product_ID in" . $IDs;

	if(!$result = $connect->query($query)) {
		die('Error query');
	}

	$result_array = array();
	while($picksRow = $result->fetch_assoc()){
		array_push($result_array,$picksRow);
	}

	print_r($result_array);

	echo $query;


	$len = sizeof($_SESSION['cartArray']);
	for($i=0;$i< $len;$i++) {
		echo "<div id='productCanvas'> works" . $_SESSION['cartArray'][$i];  
		echo "</div>";

	}

	echo "<a class='link' href='checkout_view.php'><div id='tocheckout'><p>Checkout</p></div></a>"
?>
