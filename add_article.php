<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/Article.php";

    $errors = array();
    
    if(!empty($_SESSION["admin_email"]))
    {
        if(!empty($_POST)) { 
    
            if(empty($_POST["art_title"]))
                $errors[] = "Error: Title is empty!";

            if(empty($_POST["art_desc"]))
                $errors[] = "Error: Description is empty!";

            if(empty($_FILES["art_image"]))
                $errors[] = "Error: No image is selected!";
            elseif($_FILES["art_image"]["type"] != "image/jpeg" && $_FILES["art_image"]["type"] != "image/jpg" && $_FILES["art_image"]["type"] != "image/png") {
            	$errors[] = "Error: Invalid file. Please choose a JPEG or PNG file!";
            }
            //var_dump($_FILES["art_image"]);

            if(empty($errors) ) {

                $article = new Article();

                $output = $article->article_exists($_POST["art_title"]);
                if ($output) {
                    $errors[] = "Error: Article already exists!";
                }
            
                if(!$output)
                {
                    $title = $_POST["art_title"];
                    $desc = $_POST["art_desc"];
                    $img_name = $_FILES['art_image']['name'];
                    $target_dir = "images/upload_images/";
                    $target_file = $target_dir.$img_name;
                   
                    $output = $article->add_article($title, $desc, $target_file);
                    if ($output) {
                        $errors[] = "Article added successfully!";
                        move_uploaded_file($_FILES['art_image']['tmp_name'],$target_file);
                    }
                    else
                        $errors[] = "Error: unable to add";
                }      
            }
        }
        echo $twig->render('add_article.html.twig', array('errors' => $errors));
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
