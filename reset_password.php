<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    
    $errors = array();
    
    if(!empty($_POST)) { 

        if(empty($_POST["password"]))
            $errors[] = "Error: Password is empty!";

        if(empty($_POST["conf_password"]))
            $errors[] = "Error: Retype Password is empty!";
        elseif ($_POST["password"] != $_POST["conf_password"]) {
            $errors[] = "Error: Password does not match!";
        }
        
        
        if(empty($errors) ) {

            $user = new User();
            if ($_SESSION["email"]) {
                $pwd = $_POST["password"];
                $output = $user->reset_pwd($_SESSION["email"], $pwd);

                if ($output) 
                {
                    $errors[] = "Password changed successfully!";
                    //header("location: login.php");
                }  
                else
                {
                    $errors[] = "Error:";
                } 
            }
        }
    }
    echo $twig->render('reset_password.html.twig', array('errors' => $errors));
