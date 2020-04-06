<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();

    if(!empty($_POST))
    {
        if(empty($_POST["email"]))
            $errors[] = "Error: Email is empty!";
        elseif (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
            $errors[] = "Error: Invalid email address!";
    
        if(empty($errors))
        {
            $user = new User();
            $verify = $user->verify_user($_POST["email"]);
            if ($verify) {

                $sent = $user->send_verify_mail($_POST["email"]);
                if($sent)
                    $errors[] = "Check mail";
                    //header('location: reset_password.php');
                else
                    $errors[] = "Error: ";
            }
            else
            {
                $errors[] = "Error: User does not exists with this email!";
            }
        }
    }
    //echo $twig->display('header.html.twig');
    echo $twig->render('enter_email.html.twig', array('errors' => $errors));
   