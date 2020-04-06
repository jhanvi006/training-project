<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();

    $user = new User();
    $sql = "Select * from user where first_name='".$_SESSION["username"]."'";
    $output = $user->SelectOne($sql);

    if(!empty($_POST))
    {
        if (!preg_match("/^[a-zA-Z]*$/",$_POST["firstName"])) 
            $errors[] = "Error: Name contains only alphabets!";
    
        if(empty($errors))
        {
            $update = $user->edit_user($_POST["firstName"], $_POST["email"]);
            if ($update) {
                $errors[] = "Upadated data successfully!";
            }
            else
            {
                $errors[] = "Error:";
            }
        }
    }
    echo $twig->display('header.html.twig');
    echo $twig->render('edit_user.html.twig', ['output' => $output, 'errors' => $errors]);
   