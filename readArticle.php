<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Posts.php";

if(!empty($_SESSION["email"]))
{
	$post = new Posts();

	$id = $_GET["art_id"];
	$output = $post->content($id);
	//var_dump($output);
	//echo $twig->render('home.html.twig', ['output' => $output, 'page' => $page, 'last' => $last, 'countRecords' => $countRecords, 'record_limit' => $record_limit]);
	echo $twig->render('readArticle.html.twig', array('output' => $output));
}
else
{
	header("location: login.php");
}
