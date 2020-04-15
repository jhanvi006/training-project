<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Category.php";


if(!empty($_SESSION["admin_email"]))
{
	$category = new Category();
	$output = $category->display_category();

	$countRecords = $category->count_records();

	$record_limit = 2;
	if( isset($_GET["page"] ) ) 
		$page = $_GET["page"];
	else 
		$page = 1;
	
	$left_records = $countRecords - ($page * $record_limit);

	echo $twig->render('disp_category.html.twig', ['output' => $output, 'page' => $page, 'left_records' => $left_records, 'record_limit'=> $record_limit, 'countRecords' => $countRecords]);
}
else
{
    echo "You are not allowed to access the page!";
}