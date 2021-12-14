<?php
    session_start();
    // TODO
    //Redirect to front page if user is not admin.
    if(empty($_SESSION['admin_id'])) {
		header('Location: index.php');

        //https://thedailywtf.com/articles/WellIntentioned-Destruction
        die();
	}
?>

<!DOCTYPE html>
<html>
   	<head>
		<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        	<title>e-com/productview</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/add_product.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>
    
	<body>
        <?php include 'menu.php'; ?>
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
                <br> <!-- You think I care -->
                <div class="half">
                    <label>Picture URL</label>
                    <input name="url" placeholder="Enter url to picture" required>
                </div>
                <div class="half">
                    <label>Category</label>
                    <input name="category" placeholder="Enter category" required>
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
                        !empty($_POST['url']) &&
                        !empty($_POST['category']))
					{
						include 'init.php';
						$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
						
						$name = mysqli_real_escape_string($connect, $_POST['name']);
                        $stock = mysqli_real_escape_string($connect, $_POST['stock']);
                        $price = mysqli_real_escape_string($connect, $_POST['price']);
                        $description = mysqli_real_escape_string($connect, $_POST['description']);
                        $url = mysqli_real_escape_string($connect, $_POST['url']);
                        $category = mysqli_real_escape_string($connect, $_POST['category']);

                        if (mysqli_query($connect, "insert into Product (Name, Stock, Description, Price, URL, Category) values ('$name', '$stock', '$description', '$price', '$url', '$category');")) {
                            echo "<div class='success'>Listing created.</div>";
                        }
					}
				}
			?>
		</div>
	</body>
</html>
