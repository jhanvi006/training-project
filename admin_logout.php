<?php
	session_start();

	if(!isset($_SESSION["admin_email"]))
	{
		header("location:admin_login.php");
		exit;
	}

	unset($_SESSION["admin_email"]);

	header("location: disp_category.php");

?>