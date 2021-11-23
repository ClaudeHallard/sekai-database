<?php
	echo "<div class='topbar'>";
	echo "<div class='home'>
			<a href='index.php' class='material-icons'>home</a><br>
			Home
		</div>";
	echo "<div class='cart'>
			<a href='#' class='material-icons'>shopping_cart_checkout</a><br>
			Cart
		</div>";

	if(!empty($_SESSION['user_id'])){
		echo "<div class='cart'>
				<a href='logout.php' class='material-icons'>logout</a><br>
				Cart
			</div>";
	}else{
		echo "<div class='cart'>
				<a href='register.php' class='material-icons'>person_add</a><br>
				Signup
			</div>";
		echo "<div class='cart'>
				<a href='login.php' class='material-icons'>login</a><br>
				Login
			</div>";
	}
	echo "</div>";
?>
