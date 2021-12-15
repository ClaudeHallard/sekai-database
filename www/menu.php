<?php
	# https://www.w3schools.com/howto/howto_js_toggle_hide_show.asp
	echo "<script>
		function showCart() {
		  var x = document.getElementById('canvas');
		  if (x.style.display === 'none') {
			x.style.display = 'block';
		  } else {
			x.style.display = 'none';
		  }
		}
	</script>";

	echo "<div class='topbar'>";
	echo "<div class='home'>
			<a href='index.php' class='material-icons'>home</a>
			<p>Home</p>
		</div>";
	echo "<div class='cart'>
			<i onclick='showCart()' class='material-icons'>shopping_cart_checkout</i>
			<p>Cart</p>
		</div>";

	if(!empty($_SESSION['user_id'])){
		echo "<div class='cart'>
				<a href='logout.php' class='material-icons'>logout</a>
				<p>Logout</p>
			</div>";

		echo "<div class='cart'>
				<a href='order_history.php' class='material-icons'>history</a>
				<p>Orders</p>
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
	
	echo"	
	<div id='canvas'>
		<div id='top-pointer'> </div>
		<iframe name='iframeCart' id='cartFrame' src='addToCart.php' height='400' width='300' name='IframeCart'></iframe>
	</div>";
?>
