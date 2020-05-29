<?php

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Posts.php";

$posts = new Posts();
$categories = $posts->getCategory();

$record_limit = 10;

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
}

foreach ($_POST["cat_value"] as $value) {
	if(!empty($value))
	{
		$output1[] = $posts->searched_article($value, $record_limit, $offset);
	}
}

if(!empty($_POST["search_text"]))
{
	$output1[] = $posts->searched_article($_POST["search_text"], $record_limit, $offset);
}

foreach ($output1 as $output_value) {
	$ids = array_column($output_value, 'article_id');
	$ids = array_unique($ids);
}
$output[] = array_filter($output_value, function ($key, $value) use ($ids) {
    return in_array($value, array_keys($ids));
}, ARRAY_FILTER_USE_BOTH);
	
echo $twig->render('search.html.twig', ['categories' => $categories, 'output' => $output, 'page' => $page, 'last' => $last, 'countRecords' => $countRecords, 'record_limit' => $record_limit]);
//echo $twig->render('search.html.twig', ['categories' => $categories, 'output' => $output]);