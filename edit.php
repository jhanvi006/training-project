<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();

    if(!empty($_SESSION["email"]))
    {
        $user = new User();
        $sql = "Select * from user where email='".$_SESSION["email"]."'";
        $output = $user->SelectOne($sql);
        
        if(!empty($_POST))
        {

            if (!preg_match("/^[a-zA-Z]*$/",$_POST["firstName"])) 
                $errors[] = "Error: Name contains only alphabets!";
            if (!preg_match("/^[a-zA-Z]*$/",$_POST["lastName"])) 
                $errors[] = "Error: Name contains only alphabets!";
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
                $errors[] = "Error: Invalid email address!";
            if (! ctype_digit($_POST["phone"]) || strlen($_POST["phone"]) != 10) 
                $errors[] = "Error: Phone must be valid 10 digits!";
        
            if(empty($errors))
            {
                $email_cond = $output["email"];
                $update = $user->edit_user($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["phone"], $email_cond);
                if ($update) {
                    $errors[] = "Upadated data successfully!";
                }
                else
                {
                    $errors[] = "Error:";
                }
            }
        }
        
        echo $twig->render('edit_user.html.twig', ['output' => $output, 'errors' => $errors]);
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   