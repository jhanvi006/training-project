<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();
    $user = new User();
    $sql = "Select * from user where first_name='".$_SESSION["username"]."'";
    $output = $user->SelectOne($sql);

    if(!empty($_POST)) { 

        if(empty($_POST["password"]))
            $errors[] = "Error: Password is empty!";

        if(empty($_POST["conf_password"]))
            $errors[] = "Error: Retype Password is empty!";
        elseif ($_POST["password"] != $_POST["conf_password"]) {
            $errors[] = "Error: Password does not match!";
        }
    
        if(empty($errors) ) {
            // Data entry
            $user = new User();

            $email = $output["email"];
            $pwd = $_POST["password"];
            $output = $user->reset_pwd($email, $pwd);
            if ($output) {
                $errors[] = "Password changed successfully!";
            }  
            else
                $errors[] = "Error:"; 
        }
                
    }
    
    echo $twig->render('reset_password.html.twig', array('errors' => $errors));
