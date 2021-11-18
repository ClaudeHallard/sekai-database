<?php
	session_start();


	if(!empty($_POST['addToCart'])) {
		$productID = $_POST['addToCart'];
		if($productID == 1) {
			$cart = array();

		}
		array_push($cart,$productID);

	}

	$len = sizeof($cart);
	for($i=0;$i< $len;$i++) {
		echo "<p> works $cart[$i] </p>";
	}
?>
