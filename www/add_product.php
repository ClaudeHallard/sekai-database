<?php
    session_start();
    // TODO
    //Redirect to front page if user is not admin.
    //if(!empty($_SESSION['admin_id'])) {
	if(!empty($_SESSION['user_id'])) { //Testing purposes
		header('Location: index.php');

        //https://thedailywtf.com/articles/WellIntentioned-Destruction
        die();
	}
?>

<!DOCTYPE html>
<html>
   	<head>
		<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        	<title>e-com/productview</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/add_product.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>
    
	<body>
        <?php include 'menu.php'; ?>
		<!-- <div class="topbar">
			<a href="index.php" class="home material-icons">home</a>
		    <a href="#" class="cart material-icons">shopping_cart_checkout</a>
		</div><div> -->
		<div class="add_product">
			<div class="header">ADD PRODUCT TO SITE</div>
			<form action="" method="post" id="product" autocomplete="off">
                <div>
                    <label>Name</label><br>
                    <input name="name" placeholder="Enter product name" required><br>
                </div>
                <div class="half">
                    <label>Stock</label>
                    <input name="stock" placeholder="Enter stock amount" required>
                </div>
                <div class="half">
                    <label>Price</label>
                    <input name="price" placeholder="Enter price" required>
                </div>
                <label>Description</label><br>
                <textarea name="description" form="product" placeholder="Enter product description"></textarea><br>
                <input type="submit" class="submit" name="SubmitButton" value="Create Product Listing"/>
			</form>

			<?php
				if(isset($_POST['SubmitButton'])){
					if (!empty($_POST['name']) &&
                        !empty($_POST['stock']) &&
                        !empty($_POST['price']) &&
                        !empty($_POST['description']))
					{
						include 'init.php';
						$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
						
						$name = mysqli_real_escape_string($connect, $_POST['name']);
                        $stock = mysqli_real_escape_string($connect, $_POST['stock']);
                        $price = mysqli_real_escape_string($connect, $_POST['price']);
                        $description = mysqli_real_escape_string($connect, $_POST['description']);
					
                        if (mysqli_query($connect, "insert into Product (Name, Stock, Description, Price) values ('$name', '$stock', '$description', '$price');")) {
                            echo "<div class='success'>Listing created.</div>";
                        }
					}
				}
			?>
		</div>
	</body>
</html>
