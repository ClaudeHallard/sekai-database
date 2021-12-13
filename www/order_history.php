<?php
    session_start();
    //Redirect to front page if user logged in.
	if(empty($_SESSION['user_id'])) {
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
        	<title>e-com/history</title>
        	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/order_history.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>
    
	<body>
        <?php include 'menu.php'; ?>

			<?php
                include 'init.php';
                $connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
                
                //$orders = mysqli_query($connect, "SELECT ordered_product.*, product.Name FROM ordered_product, product WHERE ordered_product.Order_ID in 
                //    (SELECT Order_ID FROM product_order WHERE Customer_ID='" . $_SESSION['user_id'] . "')");
                $orders = mysqli_query($connect, 
                "SELECT ordered_product.*, product.Name 
                FROM 
                product_order
                JOIN
                ordered_product
                ON
                product_order.Order_ID = ordered_product.Order_ID
                LEFT JOIN
                product 
                ON
                ordered_product.Product_ID = product.Product_ID
                WHERE
                Customer_ID=" . $_SESSION['user_id'] . ";");

                if(!$orders) {
                    die('Error query');
                }
                echo "<div class='orders'>Your orders:";
                $lastID = -1;
                while($order = $orders->fetch_assoc())
                {
                    if($lastID == -1)
                    {
                        echo "<div class='order'>";
                        echo "<div class='order_header'>ID: " . $order["Order_ID"] . "</div>";
                    }
                    else if($order["Order_ID"] != $lastID)
                    {
                        echo "</div>";
                        echo "<div class='order'>";
                        echo "<div class='order_header'>ID: " . $order["Order_ID"] . "</div>";
                    }

                    echo "<b>".$order["Name"] . "</b><br> Amount: " . $order["Amount"] ." Price: ".$order["Price"]."<br><br>";
                    $lastID = $order["Order_ID"];
                }
                echo "</div>";
			?>
		</div>
	</body>
</html>
