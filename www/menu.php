<?php
	echo "<div class='topbar'>";
	echo "<div class='home'>
			<a href='index.php' class='material-icons'>home</a>
			<p>Home</p>
		</div>";
	echo "<div class='cart'>
			<a href='#' class='material-icons'>shopping_cart_checkout</a>
			<p>Cart</p>
		</div>";

	if(!empty($_SESSION['user_id'])){
		echo "<div class='cart'>
				<a href='logout.php' class='material-icons'>logout</a>
				<p>Logout</p>
			</div>";
		if(!empty($_SESSION['admin_id'])){
			echo "<div class='cart'>
				<a href='add_product.php' class='material-icons'>add_circle_outline</a>
				<p>Add Listing</p>
			</div>";
		}
	}else{
		echo "<div class='cart'>
				<a href='register.php' class='material-icons'>person_add</a>
				<p>Signup</p>
			</div>";
		echo "<div class='cart'>
				<a href='login.php' class='material-icons'>login</a>
				<p>Login</p>
			</div>";
	}
	echo "</div>";
?>
