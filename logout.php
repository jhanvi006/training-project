<?php
	session_start();

	if(!isset($_SESSION["email"]))
	{
		header("location:login.php");
		exit;
	}

	unset($_SESSION["email"]);

	header("location: home.php");

?>