<?php

    session_start();

    /*error_reporting(E_ALL);
    ini_set('display_errors', 1);*/

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

            $email = $_POST["email"];
            $password = $_POST["password"];
            //$output = $user->login($_POST["email"],$_POST["password"]);
            $output = $user->login($email,$password);

            if ($output) {
                //$errors[] = "Login successful!";

                $u_sql = "Select * from user where email='$email'";
                $user_name = $user->selectOne($u_sql);
                $_SESSION["email"] = $user_name["email"];
                $_SESSION["fname"] = $user_name["first_name"];
                //$name = $user_name["first_name"];
                header("location: home.php");
            }
            else
            {
                $errors[] = "Error: Incorrect email id or password!";
            }      
        }
                
    }
    //echo $twig->render('header.html.twig', array('user_name' => $user_name));
    echo $twig->render('login.html.twig', array('errors' => $errors));