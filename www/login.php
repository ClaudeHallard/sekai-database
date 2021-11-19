<?php
    session_start();
    //Redirect to front page if user logged in.
	if(!empty($_SESSION['user_id'])) {
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
		<link rel="stylesheet" href="css/register.css">
		<link rel="stylesheet" href="css/menu.css">
	</head>
    
	<body>
        <?php include 'menu.php'; ?>
		<!-- <div class="topbar">
			<a href="index.php" class="home material-icons">home</a>
		    <a href="#" class="cart material-icons">shopping_cart_checkout</a>
		</div><div> -->
		<div class="registerform">
			<div class="login">LOGIN</div>
			<form action="" method="post" autocomplete="off">
				<label>Email</label><br>
                <input type='text' id='Email' name='email' value='<?php if(!empty($_POST['email'])) echo $_POST['email']?>' placeholder='Enter email' required><br>
				<label>Password</label><br>
				<input type="password" id="Password" name="password" placeholder="**********" required><br>
				<input type="submit" class="submit" name="SubmitButton" value="Login Account"/>
			</form>

			<?php
				if(isset($_POST['SubmitButton'])){
					if (!empty($_POST['email']) &&
                        !empty($_POST['password']))
					{
						include 'init.php';
						$connect = new mysqli($dbsever,$dbusername,$dbpassword, $dbname) or die("can't connect");
						
						$email = mysqli_real_escape_string($connect, $_POST['email']);
						$password = hash("sha512", $_POST['password']);
						
						$result = mysqli_query($connect, "SELECT CustomerID FROM customer WHERE Email='$email' AND Password='$password'");
						if(mysqli_num_rows($result) > 0){
							$_SESSION['user_id'] = $result->fetch_row()[0];
						    echo "<script>window.location.replace('index.php')</script>";
						} else{
							echo "<div class='error'>Either password or email is wrong. Try again.</div>";
						}	
					}
				}
			?>
		</div>
	</body>
</html>
