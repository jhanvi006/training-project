<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/Article.php";

    $errors = array();

    if(!empty($_SESSION["admin_email"]))
    {
        $article = new Article();
        $sql = "Select * from article where article_id='".$_GET["art_id"]."'";
        $output = $article->SelectOne($sql);
            
        $update = $article->delete_article($output["article_id"]);
        if ($update) 
        {
            header("location: disp_articles.php");
        }
        else
        {
            $errors[] = "Error: Cannot delete article!";
        }
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   