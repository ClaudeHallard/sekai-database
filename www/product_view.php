<?php
    session_start();
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
				
				$productID = 1;
				if(!empty($_GET['product_id'])) {
					$productID = $connect->real_escape_string($_GET['product_id']);
				}
				
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
			
			<div class="container1">
				<div class="description">
					<?php echo "<p>$product_description</p>" ?>
				</div>
				<div>
					<?php
					echo "<form method='post' target='iframeCart' action='addToCart.php'>";
					echo "<input type='hidden' name='addToCart' value='$productID'>";
					echo "<input class='addProdButton' type='submit' value='Add to cart'>";
					echo "</form>"; 
					?>
				</div>				
			</div>
			<?php

			if(!empty($_SESSION['user_id'])){
				echo "<div class='ReviewForm'>
					<form action='' method='post' autocomplete='off'>
						<label for='fname'>Grade (1-5):</label><br>
						<input type='number' min='1' max='5' id='grade' name='grade'><br>
						<label for='writeReview'>Review:</label><br>
						<textarea id='writeReview' name='writeReview' rows='5' cols='21'></textarea><br>						
						<input type='submit' class='submit' name='SubmitRevButton' value='Submit Review'/>
					</form>
				</div>";
			}
			
			//mysqli_query($connect,"INSERT INTO review (Customer_ID, Grade, Text) VALUES ('$_SESSION[user_id]', '2', 'I really likelike it')");
			if(isset($_POST['SubmitRevButton'])){
				$grade = $_POST['grade'];
				$reviewText = $_POST['writeReview'];
				$stmt = $connect->prepare("INSERT INTO review (Customer_ID, Product_ID, Grade, Text) VALUES (?, ?, ?, ?)");
				$stmt->bind_param("ssss", $_SESSION['user_id'], $productID, $grade, $reviewText);
				$stmt->execute();
				header("Location: product_view.php?product_id=" . $productID);
				exit; 
			}
			?>

			<!--dhttps://www.positronx.io/create-html-scroll-box/-->
			<div class="review">
				<?php
					#$grab = "SELECT * FROM review WHERE Product_ID='$productID'";
					$grab = "SELECT r.*, c.FirstName FirstName FROM review r NATURAL JOIN customer c WHERE r.Product_ID='$productID' AND c.CustomerID = r.Customer_ID";
					$result = mysqli_query($connect, $grab);
					echo"<div style='border-radius:15px; border: 2px solid #000; border-top-left-radius:0px; color:#fff; background-color:#000; font-family: great vibes, cursive; margin:0px; padding:0px; width: 130px;' > Reviews </div>";
					echo"<hr>";
					While($row = $result->fetch_assoc()){
						echo" <p style='font-size:24pt; font-weight:bold; margin:0px; font-family: Arial;'>Customer : $row[FirstName] </p> ";
						echo"Grade: $row[Grade] <br>";
						echo"$row[Text] <br>";
						echo"<hr>";
						echo"<br>";
					}
				?>
			</div>
		</div>

	</body>
</html>
