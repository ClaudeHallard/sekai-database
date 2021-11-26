<html>

	<head>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/addToCartStyle.css">
	</head>

<?php

	session_start();

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include 'init.php';
	$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
	$connect->set_charset("utf8");
	
	$cart = array();
	$IDs = "('";
	$plus = 0;
	if(!empty($_POST['addToCart'])) {
		$productID = $connect->real_escape_string($_POST['addToCart']);

		/*print_r($cart);*/

		if(!empty($_SESSION['user_id'])){
			$getCart = "select * from cart_product where Customer_ID = '" . $_SESSION['user_id'] . "'";
			if(!$cartResult = $connect->query($getCart)) {
				die('Error query get cart');
			}

			$result_array = array();
			while($picksRow = $cartResult->fetch_assoc()){
				array_push($result_array,$picksRow);
			}

			$len = sizeof($result_array);
			for($i=0;$i< $len;$i++) {
				$utfEncodedArray = array_map("utf8_encode", $result_array[$i] );
				
				if($productID == $utfEncodedArray['Product_ID']) {
					$newAmount = $utfEncodedArray['Amount']+1;
					$increaseAmount = "UPDATE cart_product SET Amount ='$newAmount' 
					WHERE Product_ID = '$productID'";
					$cart[$utfEncodedArray['Product_ID']] = $newAmount;
					$plus = 1;

					$connect->begin_transaction();
					try {
						$connect->query($increaseAmount);
						$connect->commit();
					} catch (mysqli_sql_exception $exception) {
						$connect->rollback();
						throw $exception;
					}
				} else {
					$cart[$utfEncodedArray['Product_ID']] = $utfEncodedArray['Amount'];
				}
				$IDs .= $utfEncodedArray['Product_ID'] . "','";
			}

			if($plus == 0) {
				$sql = "insert into cart_product (Customer_ID, Product_ID, Amount) 
				values ('" . $_SESSION['user_id'] . "', '$productID', '1',)";	
				$inToCart = "INSERT INTO cart_product (Customer_ID, Product_ID, Amount)
VALUES ('" . $_SESSION['user_id'] ."', '" . $productID . "', '1');";
				/*if($connect->query($inToCart)) {
					die('Error query add to cart');
				}*/

				$connect->begin_transaction();
				try {
					$connect->query($inToCart);
					$connect->commit();
				} catch (mysqli_sql_exception $exception) {
					$connect->rollback();
					throw $exception;
				}
				$cart[$productID] = 1;
				$IDs .= $productID;
			}
			$IDs .= "')";
			$_SESSION['cartArray'] = $cart;
			
		} else {
			foreach($_SESSION['cartArray'] as $key => $value) {
				if($productID == $key) {
					$cart[$key] = $value+1;
					$plus = 1;
				} else {
					$cart[$key] = $value;
				}
			
				$IDs .= $key . "','";
			}		
			if($plus == 0){
				$cart[$productID] = 1;
				$IDs .= $productID;
			}
			$IDs .= "')";
			$_SESSION['cartArray'] = $cart;
		}

	} else {
		$subProductID = NULL;
		if(!empty($_POST['subToCart'])) {
			$subProductID = $connect->real_escape_string($_POST['subToCart']);
		}

		if(!empty($_SESSION['user_id'])){
			$getCart = "select * from cart_product where Customer_ID = '" . $_SESSION['user_id'] . "'";
			if(!$cartResult = $connect->query($getCart)) {
				die('Error query get cart');
			}

			$result_array = array();
			while($picksRow = $cartResult->fetch_assoc()){
				array_push($result_array,$picksRow);
			}

			$len = sizeof($result_array);
			for($i=0;$i< $len;$i++) {
				$utfEncodedArray = array_map("utf8_encode", $result_array[$i] );
				
				if($subProductID == $utfEncodedArray['Product_ID']) {
					if($utfEncodedArray['Amount'] > 1) {
						$newAmount = $utfEncodedArray['Amount']-1;
						$increaseAmount = "UPDATE cart_product SET Amount ='$newAmount' 
						WHERE Product_ID = '$subProductID'";
						$cart[$utfEncodedArray['Product_ID']] = $newAmount;

						$connect->begin_transaction();
						try {
							$connect->query($increaseAmount);
							$connect->commit();
						} catch (mysqli_sql_exception $exception) {
							$connect->rollback();
							throw $exception;
						}
					} else {

						$del = "DELETE FROM cart_product WHERE Customer_ID ='" . $_SESSION['user_id'] ."' AND 
						Product_ID ='" . $subProductID . "';";

						$connect->begin_transaction();
						try {
							$connect->query($del);
							$connect->commit();
						} catch (mysqli_sql_exception $exception) {
							$connect->rollback();
							throw $exception;
						}

						continue;
					}
				} else {
					$cart[$utfEncodedArray['Product_ID']] = $utfEncodedArray['Amount'];
				}
				$IDs .= $utfEncodedArray['Product_ID'] . "','";
			}
			$IDs .= "')";
			$_SESSION['cartArray'] = $cart;			
		}

		else {
			foreach($_SESSION['cartArray'] as $key => $value) {
				if($subProductID == $key){
					if($value > 1) {
						$cart[$key] = $value-1;
					} else {
						continue;
					}
				} else {
					$cart[$key] = $value;
				}
				$IDs .= $key . "','";
			}		
			$IDs .= "')";
			$_SESSION['cartArray'] = $cart;
		}
	}
	
	
	$query = "select * from product where Product_ID in" . $IDs;

	if(!$result = $connect->query($query)) {
		die('Error query');
	}

	$result_array = array();
	while($picksRow = $result->fetch_assoc()){
		array_push($result_array,$picksRow);
	}

	/*print_r($_SESSION['cartArray']);

	echo $query;*/

	$len = sizeof($_SESSION['cartArray']);
	for($i=0;$i< $len;$i++) {
		/*echo "<div id='productCanvas'>" . $result_array[$i]['Name'] . $_SESSION['cartArray'][$i];  
		echo "</div>";*/
		echo "<div id='cartproduct'>";
		    echo "<div id='cartText'>";
		        echo "<div id='cartpicture'></div>";
		        echo "<div style='top: 0px;'>";
		            echo "<p class='cartProductText'>" . $result_array[$i]['Name'] . "</p>";
		            echo "<p class='cartProductText'>" . $result_array[$i]['Price'] ." kr </p>";
		        echo "</div>";
		        echo "<div style='float: right; top: 0px; position: relative;'>";
		            echo "<div id='sizeIn'>";

				echo "<form id='marginNone' method='post' action=''>";
				echo "<input type='hidden' name='subToCart' value='" . $result_array[$i]['Product_ID'] . "'>";
				echo "<button id='mi' type='submit'> <i class='material-icons' id='leftarraw'>chevron_left</i> </button>";
				echo "</form>";


		                /*echo "<div id='mi'><i class='material-icons' id='leftarraw'>chevron_left</i></div>";*/
		                echo "<div id='in'><p id='demo'>" . $_SESSION['cartArray'][$result_array[$i]['Product_ID']] ."</p></div>";

				echo "<form id='marginNone' method='post' action=''>";
				echo "<input type='hidden' name='addToCart' value='" . $result_array[$i]['Product_ID'] . "'>";
				echo "<button id='pl' type='submit'><i class='material-icons' id='rightarraw'>chevron_right</i></button>";
				echo "</form>";


		                /*echo "<div id='pl'><i class='material-icons' id='rightarraw'>chevron_right</i>";
		               echo "</div>";*/
		            echo "</div>
		        </div>
		    </div>
		</div>";

	}

	/*echo $result_array[0]['Stock'];
	echo var_dump($result_array[0]['Product_ID']);*/
	$outOfStack = 0;
	if(!empty($_POST['set'])) {
		foreach($_SESSION['cartArray'] as $key => $value) {
			/*for($i=0;$i< $len;$i++) {
				if($result_array[$i]['Product_ID'] == $key) {
					if($result_array[$i]['Stock'] < $value) {
						echo "We have only " . $result_array['Stock'] . "pieces of " . $result_array[$i]['Name'];
						$outOfStack = 1;
					}
				}
			}*/
			/*echo var_dump($key) . "key";
			echo var_dump($result_array[0]['Product_ID']) . "Product_ID";*/
			/* https://www.php.net/manual/en/function.array-search.php */
			$i = array_search($key, array_column($result_array, 'Product_ID'));
			if($result_array[$i]['Stock'] < $value) {
				$pri = "We have only " . $result_array[$i]['Stock'] . "pieces of " . $result_array[$i]['Name'];
				echo $pri;
				$outOfStack = 1;
			}

		}

		if($outOfStack == 0) {
			/* https://www.generacodice.com/es/articolo/1162991/PHP-%238220;header-(location)%238221;-inside-IFRAME,-to-load-in-_top-location */
			echo "<script>top.window.location = 'checkout_view.php'</script>";
			die;
			/*header("Location: checkout_view.php#top");
			exit();*/
		}
	}



	echo "<form method='post' action=''>";
	echo "<input type='hidden' name='set' value='set'>";
	echo "<input id='tocheckout' type='submit' value='Checkout'>";
	echo "</form>";

	/*echo "<a class='link' href='checkout_view.php'><div id='tocheckout'><p>Checkout</p></div></a>"*/
?>






