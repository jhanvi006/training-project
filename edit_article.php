<?php

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/Article.php";

    $errors = array();

    if(!empty($_SESSION["admin_email"]))
    {
        $article = new Article();
        $sql = "SELECT * FROM article WHERE article_id='".$_GET["art_id"]."'";
        $output = $article->SelectOne($sql);

        $sql = "SELECT article_cat_id FROM article_categories WHERE article_id='".$_GET["art_id"]."'";
        $cat_id = $article->selectAll($sql);
        echo $cat_id;
        $categories = $article->getCategory();

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
            //echo mime_content_type($output["image"])."<br>";
            // var_dump($_FILES["edit_art_image"]);
            // if(empty($_FILES["edit_art_image"]))
            // {
            //     $file = $output["image"];
            //     //echo $_FILES["edit_art_image"];
            //     $ext = mime_content_type($file);
            //     if($ext != "image/jpeg" && $ext != "image/jpg" && $ext != "image/png")
            //         $errors[] = "Error1: Invalid file. Please choose a JPEG or PNG file!";
            //     //echo "<br>".$ext;
            // }
            //     //$errors[] = "Error: No image is selected!";
            //else 
                if(!isset($_FILES["edit_art_image"]) && $_FILES["edit_art_image"]["type"] != "image/jpeg" && $_FILES["edit_art_image"]["type"] != "image/jpg" && $_FILES["edit_art_image"]["type"] != "image/png") {
                $errors[] = "Error2: Invalid file. Please choose a JPEG or PNG file!";
            }
            //var_dump($_FILES["edit_art_image"]);

            if(empty($errors))
            {
                $title = $_POST["edit_art_title"];
                $desc = $_POST["edit_art_desc"];
                
                $id = $output["article_id"];
                $extension = pathinfo($_FILES["edit_art_image"]["name"], PATHINFO_EXTENSION);
                $img_name = "orig_".$id.".".$extension;
                $thumb_img_name = "thumb_".$id.".".$extension;
                $fileType = $_FILES["edit_art_image"]["type"];
                $target_dir = "images/upload_images/";
                $target_file = $target_dir.$img_name.".".$fileType;
                $thumb_dir = "images/upload_image_thumb/";
                $target_thumb_file = $thumb_dir.$thumb_img_name.".".$fileType;

                $update = $article->edit_article($title, $desc, $target_file, $id);
                if ($update) {
                    move_uploaded_file($_FILES['edit_art_image']['tmp_name'],$target_file);
                    $thumb_img = $article->createThumbImg($target_file, $target_thumb_file, $fileType, 50, 50);
                    if($thumb_img)
                    {
                        //echo($curr_id." ".$target_file." ".$target_thumb_file."<br>");
                        $save_image = $article->edit_image($id, $target_file, $target_thumb_file);
                        if(!$save_image)
                            $errors[] = "Error: Failed to save image!";
                    }
                    else
                        $errors[] = "Error: Failed to create thumbnail image!";
                    $errors[] = "Upadated data successfully!";
                }
                else
                {
                    $errors[] = "Error: unable to update!";
                }
            }
        }
        
        echo $twig->render('edit_article.html.twig', ['output' => $output, 'categories' => $categories, 'target_thumb_file' => $target_thumb_file,'errors' => $errors]);
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   