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

        if(!empty($_POST))
        {
            if(empty($_POST["edit_art_title"]))
                $errors[] = "Error: Title is empty!";

            if(empty($_POST["edit_art_desc"]))
                $errors[] = "Error: Description is empty!";

            // var_dump($_FILES["edit_art_image"]);
            // echo "<br>";
            // echo(empty($_FILES["edit_art_image"]));
            // echo "<br>";
            if(empty($_FILES["edit_art_image"]))
                $errors[] = "Error: No image is selected!";
            else if($_FILES["edit_art_image"]["type"] != "image/jpeg" && $_FILES["edit_art_image"]["type"] != "image/jpg" && $_FILES["edit_art_image"]["type"] != "image/png") {
                $errors[] = "Error: Invalid file. Please choose a JPEG or PNG file!";
            }
            

            if(empty($errors))
            {
                $title = $_POST["edit_art_title"];
                $desc = $_POST["edit_art_desc"];
                $img_name = $_FILES["edit_art_image"]["name"];
                $target_dir = "images/upload_images/";
                $target_file = $target_dir.$img_name;


                $update = $article->edit_article($title, $desc, $target_file, $output["title"]);
                if ($update) {
                    $errors[] = "Upadated data successfully!";
                }
                else
                {
                    $errors[] = "Error: unable to update!";
                }

            }
        }
        
        echo $twig->render('edit_article.html.twig', ['output' => $output, 'errors' => $errors]);
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   