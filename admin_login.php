<?php

    session_start();

    /*error_reporting(E_ALL);
    ini_set('display_errors', 1);*/

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();
    if(!empty($_POST)) { 

        //General Validation
        if(empty($_POST["a_email"]))
            $errors[] = "Error: Email is empty!";
        elseif (! filter_var($_POST["a_email"], FILTER_VALIDATE_EMAIL)) 
            $errors[] = "Error: Invalid email address!";

        if(empty($_POST["a_password"]))
            $errors[] = "Error: Password is empty!";

        if(empty($errors) ) {
            $user = new User();

            $email = $_POST["a_email"];
            $password = $_POST["a_password"];
            $output = $user->admin_login($email,$password);
           
            if ($output) {
                $errors[] = "Login successful!";

                $u_sql = "Select * from admin_user where email='$email'";
                $user_name = $user->selectOne($u_sql);
                $_SESSION["admin_email"] = $user_name["email"];
                $_SESSION["fname"] = $user_name["username"];
                //$_SESSION["lname"] = $user_name["last_name"];
                
                header("location: disp_category.php");
            }
            else
            {
                $errors[] = "Error: Incorrect email id or password!";
            }      
        }
                
    }
    echo $twig->render('admin_login.html.twig', array('errors' => $errors));