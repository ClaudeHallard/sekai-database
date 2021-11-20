<?php
	echo "<div class='topbar'>";
	echo "<a href='index.php' class='home material-icons'>home</a>";
	echo "<a href='#' class='cart material-icons'>shopping_cart_checkout</a>";

	if(!empty($_SESSION['user_id'])){
		echo "<a href='logout.php' class='cart material-icons'>logout</a>";
	}else{
		echo "<a href='register.php' class='cart material-icons'>person_add</a>";
		echo "<a href='login.php' class='cart material-icons'>login</a>";
	}
	echo "</div>";
?>
