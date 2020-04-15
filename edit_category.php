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

        if(!empty($_POST))
        {
            if(empty($_POST["edit_cat_title"]))
                $errors[] = "Error: Title is empty!";

            if(empty($_POST["edit_cat_desc"]))
                $errors[] = "Error: Description is empty!";
            
            if(empty($errors))
            {
                $cat_exists = $category->category_exists($_POST["edit_cat_title"]);
                if ($cat_exists) {
                    $errors[] = "Error: Category already exists!";
                }
                
                $update = $category->edit_category($_POST["edit_cat_title"], $_POST["edit_cat_desc"], $output["title"]);
                if ($update) {
                    $errors[] = "Upadated data successfully!";
                }
                else
                {
                    $errors[] = "Error:";
                }
            }
        }
        
        echo $twig->render('edit_category.html.twig', ['output' => $output, 'errors' => $errors]);
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   