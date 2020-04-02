<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();
    if(!empty($_POST)) { 

        //General Validation
        if(empty($_POST["firstName"]))
            $errors[] = "Error: First name is empty!";
        elseif (!preg_match("/^[a-zA-Z]*$/",$_POST["firstName"])) 
            $errors[] = "Error: Name contains only alphabets!";

        if(empty($_POST["lastName"]))
            $errors[] = "Error: Last name is empty!";
        elseif (!preg_match("/^[a-zA-Z]*$/",$_POST["lastName"])) 
            $errors[] = "Error: Name contains only alphabets!";

        if(empty($_POST["email"]))
            $errors[] = "Error: Email is empty!";
        elseif (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
            $errors[] = "Error: Invalid email address!";

        if(empty($_POST["phone"]))
            $errors[] = "Error: Phone is empty!";
        elseif( ! ctype_digit($_POST["phone"]) || strlen($_POST["phone"]) != 10)
            $errors[] = "Error: Phone must be valid 10 digits!";

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

        //$sql = "SELECT * FROM user WHERE email = '$_POST[email]'";
        $output = $user->user_exists($_POST["email"]);
        if ($output) {
            $errors[] = "Error: User already exists!";
        }
    
        if(!$output)
        {
            /*$fname = $_POST["firstName"];
            $lname = $_POST["lastName"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $pwd = $_POST["password"];*/
            $sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','".$_POST["password"]."')";
            $output = $user->execute($sql);
            if ($output) {
                $errors[] = "You are registered successfully!";
            }
        }
        /*if ($output) {
            $output_s = "You are registered successfully!";
        } else {
            $errors[] = "User already exists!"; 
        } */      
        }
                
    }
    
    echo $twig->render('register.html.twig', array('errors' => $errors));
