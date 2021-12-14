<!DOCTYPE html>
<html>
   	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        	<title>e-com</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>

	<body>

		<!--<div id="l">
		    <a href="#" class="link"><i class="material-icons" id="icons">shopping_cart_checkout</i></a>
		</div>-->
		<?php  
		session_start();
		include 'menu.php';
		?>
		<div id="canvas">
			<div id="top-pointer"> </div>
			<iframe name="iframeCart" id="cartFrame" src="addToCart.php" height="400" width="300" name="IframeCart"></iframe>
		</div>
		<!--<?php echo "<h2>Det är givet att te är livet!!</h2>"; 
		echo "<p class='add'>Add</p>";?>-->
		
		<?php
			
			include 'init.php';
			$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");

			//Delete Product
			if(isset($_POST['delete'])){
				$Product_ID = $connect->real_escape_string($_POST['delete']);
				
				$connect->begin_transaction();
				try {
					$connect->query("DELETE FROM product WHERE Product_ID='$Product_ID';");
					$connect->query("DELETE FROM cart_product WHERE Product_ID='$Product_ID';");
					#mysqli_query($connect, "DELETE FROM product WHERE Product_ID='$Product_ID';");
					#mysqli_query($connect, "DELETE FROM cart_product WHERE Product_ID='$Product_ID';");
					$connect->commit();
				} catch (mysqli_sql_exception $exception) {
					$connect->rollback();
					throw $exception;
				}

				//https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php
				//Find and delete element
				$index = array_search($Product_ID, $_SESSION['cartArray']);
				if($index){
					unset($_SESSION['cartArray'][$index]);

					//Rearange array
					$_SESSION['cartArray'] = array_values($_SESSION['cartArray']);
				}
				header("Location: index.php");
				exit; 
				# https://stackoverflow.com/questions/20510243/clear-the-form-field-after-successful-submission-of-php-form
			}

			if(!empty($_GET['category'])) {
				$cleanCategory = $connect->real_escape_string($_GET['category']);
				$query = "SELECT * FROM product WHERE Category='" . $cleanCategory ."'";
			} else {
				$query = "SELECT * FROM product";
			}

			if(!$result = $connect->query($query)) {
				die('Error query');
			}

			#array to load in product information 
			$result_array = array();
			while($picksRow = $result->fetch_assoc()){
				array_push($result_array,$picksRow);
			}

			if(!isset($_SESSION['cartArray'])) {
				$cart = array();
				$_SESSION['cartArray'] = $cart;
			}
			#connect->close();

			#print_r($result_array);
			
			# category array
			$cat = array();

			echo "<div id='box'>";

			# function to add products to cart
			
			$len = sizeof($result_array);
			for($i=0;$i< $len;$i++) {
				$utfEncodedArray = array_map("utf8_encode", $result_array[$i] );
				$Product_ID = $utfEncodedArray['Product_ID'];
				$Name = $utfEncodedArray['Name'];
				$Stock = $utfEncodedArray['Stock'];
				$Description = $utfEncodedArray['Description'];
				$Price = $utfEncodedArray['Price'];
				$Picture = $utfEncodedArray['URL'];
				$Category = $utfEncodedArray['Category'];

				#pic to test
				#$Picture = "https://cdn.pixabay.com/photo/2013/07/12/18/20/shoes-153310_960_720.png";

				#print_r($utfEncodedArray);
				#foreach($utfEncodedArray as $key => $value)
				#{
					#if($key == Name) {
				if(!in_array($Category, $cat)) {
					array_push($cat, $Category);
				}
				
				echo "<div class='product'>";
				echo "<div class='pimg'>";
				echo "<img src='$Picture' alt='image of the product'/>";
				echo "</div>";
				if(!empty($_SESSION['admin_id'])){
					echo "<form onsubmit='return confirmDelete();' method='post' action='' class='delete'>";
						echo "<input type='hidden' name='delete' value='$Product_ID'>";
						echo "<input class='delete_button' type='submit' value='&times'>";
					echo "</form>";
				}
				echo "<p class='pName'> $Name </p>";
				
				echo "<form method='get' action='product_view.php'>";
				#echo "<form method='post' action='product_view.php'>";
					echo "<input type='hidden' name='product_id' value='$Product_ID'>";
					echo "<input class='toView' type='submit' value='View'>";
				echo "</form>";

				echo "<form method='post' target='iframeCart' action='addToCart.php'>";
					echo "<input type='hidden' name='addToCart' value='$Product_ID'>";
					echo "<input class='toView' type='submit' value='Add'>";
				echo "</form>";

				echo "<p class='price'>$Price kr</p>";
				/*echo "<div class='toCart'>";
				echo "<p class='add'>Add</p> </div>";*/
				echo "</div>";						

					#}
				#}


			}

			#$result->close();

			echo "<script>
				function confirmDelete() {
					return confirm('Are you sure you want to delete this?');
				}
			</script>
			</div>";
			
			echo "<div id='sidebar'> category";
			#echo "<div class='categorylist'> category";
			foreach($cat as $value) {
				echo "<form method='get' action=''>";
					echo "<input type='hidden' name='category' value='$value'>";
					echo "<input class='categorylist' type='submit' value='$value'>";
				echo "</form>";
			}		
			
			if(isset($_GET['category'])) {
				echo "<a href='index.php' title='Back' style='color: inherit; 
				text-decoration: inherit;'><div class='categorylist'> 
				<i href='index.php' class='material-icons' 
				style='font-size:50px;'>chevron_left</i> </div></a>";	
			}
			
			#echo "</div>";

			echo "</div>";
		?>
		
	</body>
</html>
