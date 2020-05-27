<?php

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Posts.php";

$posts = new Posts();
$categories = $posts->getCategory();

/*$record_limit = 3;

$countRecords = $posts->count_records();
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
}*/
if(!empty($_POST["query"]))
{
	$output = $posts->searched_article($_POST["query"]);
}
/*else
{
	$output = $posts->display_article($record_limit, $offset);
}*/

if(is_null($output))
{
	echo 'Data Not Found';
}
// echo $twig->render('search.html.twig', ['categories' => $categories, 'output' => $output, 'page' => $page, 'last' => $last, 'countRecords' => $countRecords, 'record_limit' => $record_limit]);
echo $twig->render('search.html.twig', ['categories' => $categories, 'output' => $output]);