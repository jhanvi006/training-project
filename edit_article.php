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
        $output = $article->selectOne($sql);

        $cat_sql = "SELECT article_cat_id FROM article_categories WHERE article_id='".$_GET["art_id"]."'";
        $cat_id = $article->selectAll($cat_sql);

        foreach ($cat_id as $category_id) {
            $sel_cat_id = $category_id["article_cat_id"];
            //echo $sel_cat_id."<br>";
            $selected_cat[] = $article->getSelectedCategory($sel_cat_id);
        }
        $categories = $article->getCategory();

        $img_sql = "SELECT * FROM article_image WHERE article_id='".$_GET["art_id"]."'";
        $img = $article->selectOne($img_sql);
        $disp_thumb_img = $img["thumb_img_path"];
        // $target_file = $img["org_img_path"];
        //echo $disp_thumb_img;

        //echo !empty($_FILES["edit_art_image"]);
        if(!empty($_POST))
        {
            if(empty($_POST["edit_art_title"]))
                $errors[] = "Error: Title is empty!";

            if(empty($_POST["edit_art_desc"]))
                $errors[] = "Error: Description is empty!";

            if(empty($_POST["edit_art_cat"]))
            {
                $_POST["edit_art_cat"] = $selected_cat;
                //var_dump($_POST["edit_art_cat"]);
            }
            //$errors[] = "Error: Select at least one category!";
            //var_dump($_FILES["edit_art_image"]);
            if(!isset($_FILES["edit_art_image"]) && $_FILES["edit_art_image"]["type"] != "image/jpeg" && $_FILES["edit_art_image"]["type"] != "image/jpg" && $_FILES["edit_art_image"]["type"] != "image/png") {
                $errors[] = "Error2: Invalid file. Please choose a JPEG or PNG file!";
            }

            if(empty($errors))
            {
                $title = $_POST["edit_art_title"];
                $desc = $_POST["edit_art_desc"];
                $id = $output["article_id"];
                
                if(empty($_FILES["edit_art_image"]["name"]))
                {    
                    $extension = pathinfo($output["image"], PATHINFO_EXTENSION);
                }
                else
                {
                    $extension = pathinfo($_FILES["edit_art_image"]["name"], PATHINFO_EXTENSION);
                }
                    $img_name = "orig_".$id.".".$extension;
                    $thumb_img_name = "thumb_".$id.".".$extension;
                    $fileType = $_FILES["edit_art_image"]["type"];
                    $target_dir = "images/upload_images/";
                    $target_file = $target_dir.$img_name;
                    $thumb_dir = "images/upload_image_thumb/";
                    $target_thumb_file = $thumb_dir.$thumb_img_name;

                $update = $article->edit_article($title, $desc, $target_file, $id);
                if ($update && (!empty($_FILES["edit_art_image"]))) {
                    move_uploaded_file($_FILES['edit_art_image']['tmp_name'],$target_file);
                    $article->edit_article_category($id, $_POST["edit_art_cat"], $cat_id);
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
        //echo $target_thumb_file;
        echo $twig->render('edit_article.html.twig', ['output' => $output, 'categories' => $categories, 'selected_cat' => $selected_cat, 'disp_thumb_img' => $disp_thumb_img,'errors' => $errors]);
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   