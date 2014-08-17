<?php
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['uname']);
	unset($_SESSION['uid']);
	session_destroy();
	header("location:index.php");
?>