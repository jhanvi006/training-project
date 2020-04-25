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

            if(empty($errors) ) {

    			$article = new Article();

                $title = $_POST["art_title"];
                $desc = $_POST["art_desc"];
                $img_name = $_FILES["art_image"]["name"];
                $fileType = $_FILES["art_image"]["type"];
                $target_dir = "images/upload_images/";
                $target_file = $target_dir.$img_name;
                $thumb_dir = "images/upload_image_thumb/";
               
                move_uploaded_file($_FILES['art_image']['tmp_name'],$target_file);
                echo $target_file."<br>";
                chmod($target_file, 777); 
            	$thumb_img = $article->createThumbImg($target_file, $thumb_dir, $fileType, 50, 50);
                $output = $article->add_article($title, $desc, $target_file);
                if ($output) 
                {
                	if($thumb_img)
                    	$errors[] = "Article added successfully!";
                    else
                    	$errors[] = "Error: Failed to create thumbnail image!";
                }
                else
                    $errors[] = "Error: unable to add";   
            }
        }
        echo $twig->render('add_article.html.twig', array('errors' => $errors));
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
