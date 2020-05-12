<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Article.php";


if(!empty($_SESSION["admin_email"]))
{
	$article = new Article();

	$record_limit = 5;
	$countRecords = $article->count_records();
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
	$output = $article->display_article($record_limit, $offset);
	//var_dump($output);
	foreach ($output as $values) {
		//echo $values["article_id"]."<br>";
		$cat_output = $article->display_category($values["article_id"],$record_limit, $offset);
		echo "<br>";
		var_dump($cat_output);
		// var_dump($art_id);
		// echo "<br>";

		// 	echo "key: ".key($art_id)."<br>";
		foreach ($cat_output as $value) 
		{
			$category_id = $value["article_cat_id"];
			//echo "category_id: ".$category_id."<br>";
			$cat_sql = "SELECT title FROM category WHERE cat_id=$category_id";
			$category = $article->selectAll($cat_sql);
			// echo "<br> category: ";
			// var_dump($category);
			//return $category;
			foreach ($category as $values) {
				$cat_title[] = $values["title"];
				// echo "<br> cat_title: ";
				// var_dump($cat_title);
			}
		}
	}

	echo $twig->render('disp_articles.html.twig', ['output' => $output, 'cat_title' => $cat_title, 'page' => $page, 'last' => $last, 'countRecords' => $countRecords, 'record_limit' => $record_limit]);
}
else
{
    echo "You are not allowed to access the page!";
}