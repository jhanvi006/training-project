<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Article.php";


if(!empty($_SESSION["admin_email"]))
{
	$article = new Article();

	$record_limit = 3;
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

	//echo $offset." ".$record_limit;
	// $img_sql = "SELECT thumb_img_path FROM article_image LIMIT $offset,$record_limit";
 //    $disp_thumb_img = $article->selectAll($img_sql);
 //    //var_dump($image);
 //    //$disp_thumb_img = $image;
 //    echo "disp_thumb_img:";
 //    var_dump($disp_thumb_img);
	//var_dump($output);
	foreach ($output as $values) {
		//echo $values["article_id"]."<br>";
		$cat_output[] = $article->display_category($values["article_id"],$record_limit, $offset);
	}

	echo $twig->render('disp_articles.html.twig', ['output' => $output, 'cat_output' => $cat_output, 'page' => $page, 'last' => $last, 'countRecords' => $countRecords, 'record_limit' => $record_limit]);
}
else
{
    echo "You are not allowed to access the page!";
}