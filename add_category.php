<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/Category.php";

    $errors = array();
    
    if(!empty($_SESSION["admin_email"]))
    {
        if(!empty($_POST)) { 
    
            if(empty($_POST["cat_title"]))
                $errors[] = "Error: Title is empty!";

            if(empty($_POST["cat_desc"]))
                $errors[] = "Error: Description is empty!";

            if(empty($errors) ) {

                $category = new Category();

                $output = $category->category_exists($_POST["cat_title"]);
                if ($output) {
                    $errors[] = "Error: Category already exists!";
                }
            
                if(!$output)
                {
                    $title = $_POST["cat_title"];
                    $desc = $_POST["cat_desc"];

                    $output = $category->add_category($title, $desc);
                    echo $output;
                    if ($output) {
                        $errors[] = "Category added successfully!";
                    }
                    else
                        $errors[] = "Error: unable to add";
                }      
            }
        }
        echo $twig->render('add_category.html.twig', array('errors' => $errors));
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
