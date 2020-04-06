<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// includes all necessary dependencies
require_once __DIR__ . "/includes/common.php";

// include model classes as needed
require_once __DIR__ . "/models/Posts.php";

$db = new database();
$sql = "SELECT * FROM user";
$output = $db->selectAll($sql);

/*foreach ($output as $values) {
	foreach ($values as $value) {
		echo "$value  ";
	}
	echo "<br>";
}*/
echo $twig->display('header.html.twig');
echo $twig->render('posts.html.twig', array('output' => $output));
