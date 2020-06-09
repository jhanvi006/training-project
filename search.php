<?php

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Posts.php";

$posts = new Posts();
$categories = $posts->getCategory();

$record_limit = 5;

foreach ($_POST["cat_value"] as $value) {
	if(!empty($value))
	{
		$input[] = $posts->categoryValue($value);
	}
}

if(!empty($_POST["search_text"]))
	$input[] = $_POST["search_text"];

if(empty($input))
	$sql = "SELECT * FROM article";
else
	$sql = "SELECT a.article_id, a.title, a.description, GROUP_CONCAT(c.title) AS article_categories, ai.thumb_img_path FROM article a JOIN article_image ai ON a.article_id=ai.article_id JOIN article_categories ac ON a.article_id = ac.article_id JOIN category c ON c.cat_id = ac.article_cat_id WHERE c.title LIKE '%".$search_token."%' OR a.title LIKE '%".$search_token."%' OR a.description LIKE '%".$search_token."%' GROUP BY a.article_id";
$countRecords = $posts->count_records($sql);
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


echo "<br> input:";
var_dump($input);
echo "<br>";

if(!empty($input))
{
	foreach ($input as $value) {
		$output1[] = $posts->searched_article($value, $record_limit, $offset);
	}
	// echo "<br> value: ";
	// var_dump(array_keys($output_value));
	// echo "<br>";
	//foreach ($output1 as $output_value) {
		$ids = array_column($output1, 'article_id');
		$ids = array_unique($ids);
	//}

		var_dump($ids);
		echo "<br>";
	$output1[] = array_filter($output_value, function ($key, $value) use ($ids) {
	    return in_array($value, array_keys($ids));
	}, ARRAY_FILTER_USE_BOTH);
	$output = array();
	foreach($output1 as $array) {
		foreach($array as $k=>$v) {
			$output[$k] = $v;
		}
	}
	//echo "<br><br> output: ";
	//var_dump($output);
}
else
{
	$output = $posts->display_article($record_limit, $offset);
}
	//var_dump($output);

echo $twig->render('search.html.twig', ['categories' => $categories, 'output' => $output, 'page' => $page, 'last' => $last, 'countRecords' => $countRecords, 'record_limit' => $record_limit]);
//echo $twig->render('search.html.twig', ['categories' => $categories, 'output' => $output]);