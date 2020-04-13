<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// includes all necessary dependencies
require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Category.php";


if(!empty($_SESSION["admin_email"]))
{
	$db = new database();
	$sql = "SELECT * FROM category";
	$output = $db->selectAll($sql);

	echo $twig->render('disp_category.html.twig', array('output' => $output));
}