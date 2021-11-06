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
		
		<div id="box">
			<?php
				session_start();
				include 'inti.php';
		
				$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
			
				$query = "SELECT Product_ID, Name, Stock, Description, Price
				FROM product";
				if(!$result = $connect->query($query)) {
					die('Error query');
				}
				$result_array = array();
				while($picksRow = $result->fetch_assoc()){
					array_push($result_array,$picksRow);
				}
				$json_string = json_encode($result_array);
		  		$json_get = json_decode($json_str,true);
				$connection->close();

				$len = sizeof($json_get);

				$i = 0;
				while($i < $len) {
					$Product_ID = $json_get[$i]['Product_ID'];
					$Name = $json_get[$i]['Name'];
					$Stock = $json_get[$i]['Stock'];
					$Description = $json_get[$i]['Description'];
					$Price = $json_get[$i]['Price'];

					echo "<div class='product'>";
					echo "<div class='pimg'>";
					echo "</div>";
					echo "<p class='pName'> $Name </p>";
					echo "<div class='toCart' onclick='addTOCart()'>";
					echo "<p class='add'>Add</p>";
					echo "</div></div>";

					$i++;
				}

				#$result->close();

			
			?>
		</div>
		<!--<?php
		echo "<h2>Det är givet att te är livet!</h2>"; ?>-->
	</body>
</html>
