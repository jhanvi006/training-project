<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/Category.php";

    $errors = array();

    if(!empty($_SESSION["admin_email"]))
    {
        $category = new Category();
        $sql = "Select * from category where cat_id='".$_GET["cat_id"]."'";
        $output = $category->SelectOne($sql);
            
        $update = $category->delete_category($output["cat_id"]);
        if ($update) 
        {
            header("location: disp_category.php");
        }
        else
        {
            $errors[] = "Error:";
        }
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   