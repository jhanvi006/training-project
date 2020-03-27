<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// includes all necessary dependencies
require_once __DIR__ . "/includes/common.php";

// include model classes as needed
require_once __DIR__ . "/models/Posts.php";

// get latest posts from DB
//$objPosts = new Posts();
//$posts = $objPosts->select("SELECT * FROM xf_post ORDER BY  post_id DESC LIMIT 10");

// render the template
//echo $twig->render('posts.html.twig', array('posts' => $posts));


$db = new database();
$sql = "SELECT * FROM user_detail";
$db->selectAll($sql);