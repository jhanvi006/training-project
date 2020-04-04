<?php
	session_start();

	if(!isset($_SESSION["username"]))
	{
		header("location:login.php");
		exit;
	}

	unset($_SESSION["username"]);

	header("location: home.php");

?>