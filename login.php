<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();
    if(!empty($_POST)) { 

        //General Validation
        if(empty($_POST["email"]))
            $errors[] = "Error: Email is empty!";
        elseif (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
            $errors[] = "Error: Invalid email address!";

        if(empty($_POST["password"]))
            $errors[] = "Error: Password is empty!";

        if(empty($errors) ) {
            $user = new User();

            //$sql = "SELECT * FROM user WHERE email = '".$_POST["email"]."' AND password = '".$_POST["password"]."'";

            $output = $user->login($_POST["email"],$_POST["password"]);
            //echo $output;
            if ($output) {
                $errors[] = "Login successful!";
            }
            else
            {
                $errors[] = "Error: Incorrect email id or password!";
            }      
        }
                
    }
    
    echo $twig->render('login.html.twig', array('errors' => $errors));
