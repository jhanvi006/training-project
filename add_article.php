<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/Article.php";

    $errors = array();
    
    if(!empty($_SESSION["admin_email"]))
    {
    	$article = new Article();
        $categories = $article->getCategory();
        //var_dump($categories);


        if(!empty($_POST)) { 
    
            if(empty($_POST["art_title"]))
                $errors[] = "Error: Title is empty!";

            if(empty($_POST["art_desc"]))
                $errors[] = "Error: Description is empty!";

            if(empty($_POST["art_cat"]))
            	$errors[] = "Error: Select at least one category!";

            if(empty($_FILES["art_image"]))
                $errors[] = "Error: No image is selected!";
            elseif($_FILES["art_image"]["type"] != "image/jpeg" && $_FILES["art_image"]["type"] != "image/jpg" && $_FILES["art_image"]["type"] != "image/png") {
            	$errors[] = "Error: Invalid file. Please choose a JPEG or PNG file!";
            }

            if(empty($errors) ) {

                $title = $_POST["art_title"];
                $desc = $_POST["art_desc"];

    			$id = $article->getId();
    			$curr_id = $id+1;

                $fileType = $_FILES["art_image"]["type"];
                $extension = pathinfo($_FILES["art_image"]["name"], PATHINFO_EXTENSION);
                $img_name = "orig_".$curr_id.".".$extension;
                $thumb_img_name = "thumb_".$curr_id.".".$extension;
                $target_dir = "images/upload_images/";
                $target_file = $target_dir.$img_name;
                $thumb_dir = "images/upload_image_thumb/";
                $target_thumb_file = $thumb_dir.$thumb_img_name;
               
            	$output = $article->add_article($title, $desc, $target_file);
                if ($output) 
                {
	                move_uploaded_file($_FILES['art_image']['tmp_name'],$target_file);
	                $article->addCategory($curr_id, $_POST["art_cat"]);
	            	$thumb_img = $article->createThumbImg($target_file, $target_thumb_file, $fileType, 50, 50);
	            	if($thumb_img)
	                {
		                //echo($curr_id." ".$target_file." ".$target_thumb_file."<br>");
		                $save_image = $article->addImage($curr_id, $target_file, $target_thumb_file);
		                if(!$save_image)
		                	$errors[] = "Error: Failed to save image!";
		            }
		            else
	                	$errors[] = "Error: Failed to create thumbnail image!";
                	$errors[] = "Article added successfully!";
                }
                else
                    $errors[] = "Error: unable to add";   
            }
        }
        //var_dump($category);
        echo $twig->render('add_article.html.twig', array('errors' => $errors, 'categories'=>$categories));
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
