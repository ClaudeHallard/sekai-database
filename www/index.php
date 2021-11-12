<!DOCTYPE html>
<html>
   	<head>
		<meta charset="UTF-8" />
        	<title>e-com</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/main.css">
	</head>

	<body>

		<div id="l">
		    <a href="#" class="link"><i class="material-icons" id="icons">shopping_cart_checkout</i></a>
		</div>
		<!--<?php echo "<h2>Det är givet att te är livet!!</h2>"; 
		echo "<p class='add'>Add</p>";?>-->
		<div id="box">
			<?php
				session_start();
				include 'init.php';


				$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");


				$query = "SELECT Product_ID, Name, Stock, Description, Price
				FROM product";

				if(!$result = $connect->query($query)) {
					die('Error query');
				}

				#array to load in product information 
				$result_array = array();
				while($picksRow = $result->fetch_assoc()){
					array_push($result_array,$picksRow);
				}
				#connect->close();

				#print_r($result_array);

				# function to add products to cart
				#array for Cart
				/*$p = 1;
				if($p == 1) {
					$cart = array();
					$p ++;
					echo $p;
				}
				function addThisToCart($productToAdd,$array) {
					array_push($array,$productToAdd);
					#echo "this is it " . $productToAdd;
					#echo $cart[0];

					#print_r($array);
					return $array;
				}
	
				if(isset($_POST['addToCart'])) {
					$pID = $_POST['addToCart'];
					#$cart2 = addThisToCart($pID,$cart);
					array_push($cart,$pID);
					
					print_r($cart);
				}*/
				
				$len = sizeof($result_array);
				for($i=0;$i< $len;$i++) {
					$utfEncodedArray = array_map("utf8_encode", $result_array[$i] );
					$Product_ID = $utfEncodedArray['Product_ID'];
					$Name = $utfEncodedArray['Name'];
					$Stock = $utfEncodedArray['Stock'];
					$Description = $utfEncodedArray['Description'];
					$Price = $utfEncodedArray['Price'];
					
					#print_r($utfEncodedArray);
					#foreach($utfEncodedArray as $key => $value)
					#{
	  					#if($key == Name) {


					echo "<div class='product'>";
					echo "<div class='pimg'>";
					echo "</div>";
					echo "<p class='pName'> $Name </p>";
					
					#echo "<form method='get' action='product_view.php'>";
					echo "<form method='post' action='product_view.php'>";
    					echo "<input type='hidden' name='product_id' value='$Product_ID'>";
    					echo "<input class='toView' type='submit' value='View'>";
					echo "</form>";

					/*echo "<form method='post' action=''>";
    					echo "<input type='hidden' name='addToCart' value='$Product_ID'>";
    					echo "<input class='toView' type='submit' value='Add'>";
					echo "</form>";*/

					echo "<p class='price'>$Price kr</p>";
					echo "<div class='toCart'>";
					echo "<p class='add'>Add</p> </div>";
					echo "</div>";						
	
						#}
					#}


				}


				#$result->close();


			?>
		</div>

	</body>
</html>
