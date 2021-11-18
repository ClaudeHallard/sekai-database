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

	$len = sizeof($cart);
	for($i=0;$i< $len;$i++) {
		echo "<p> works $_SESSION['CartArray'][$i] </p>";
	}
?>
