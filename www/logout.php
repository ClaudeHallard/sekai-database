<?php
	session_start();
    unset($_SESSION['user_id']);
    unset($_SESSION['admin_id']);
    unset($_SESSION['cartArray']);
    echo "<script>window.location.replace('index.php')</script>";
?>