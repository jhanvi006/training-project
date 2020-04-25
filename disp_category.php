<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Category.php";


if(!empty($_SESSION["admin_email"]))
{
	$category = new Category();

	$record_limit = 2;
	$countRecords = $category->count_records();
	$last = ceil($countRecords / $record_limit);

	if( isset($_GET["page"] ) )
	{ 
		$page = $_GET["page"];
		
		if ($page>$last) 
			$page = $last;

		$offset = ($page-1) * $record_limit; 
	}
	else 
	{
		$page = 1;
		$offset = 0;
	}
	$output = $category->display_category($record_limit, $offset);

	echo $twig->render('disp_category.html.twig', ['output' => $output, 'page' => $page, 'last' => $last, 'record_limit' => $record_limit, 'countRecords' => $countRecords]);
}
else
{
    echo "You are not allowed to access the page!";
}