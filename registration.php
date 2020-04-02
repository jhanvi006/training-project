<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();
    if(!empty($_POST)) { 

        //General Validation
        if(empty($_POST["firstName"]))
            $errors[] = "First name is empty!";
        elseif (!preg_match("/^[a-zA-Z]*$/",$_POST["firstName"])) 
            $errors[] = "Name contains only alphabets!";

        if(empty($_POST["lastName"]))
            $errors[] = "Last name is empty!";
        elseif (!preg_match("/^[a-zA-Z]*$/",$_POST["lastName"])) 
            $errors[] = "Name contains only alphabets!";

        if(empty($_POST["email"]))
            $errors[] = "Email is empty!";
        elseif (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
            $errors[] = "Invalid email address!";

        if(empty($_POST["phone"]))
            $errors[] = "Phone is empty!";
        elseif( ! ctype_digit($_POST["phone"]) || strlen($_POST["phone"]) != 10)
            $errors[] = "Phone must be valid 10 digits!";

        if(empty($_POST["password"]))
            $errors[] = "Password is empty!";

        if(empty($_POST["conf_password"]))
            $errors[] = "Retype Password is empty!";
        elseif ($_POST["password"] != $_POST["conf_password"]) {
            $errors[] = "Password does not match!";
        }
    
        if(empty($errors) ) {
        // Data entry
        $user = new User();

        //$sql = "SELECT * FROM user WHERE email = '$_POST[email]'";
        $output = $user->user_exists($_POST["email"]);
    
        if($output)
        {
            $fname = $_POST["firstName"];
            $lname = $_POST["lastName"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $pwd = $_POST["password"];
            $output = $user->execute($fname, $lname, $email, $phone, $pwd);
        }
        /*if ($output) {
            $success = "You are registered successfully!";
        } else {
            $user_error = "User already exsists!"; 
        }  */     
        }
                
    }
    
    echo $twig->render('register.html.twig', array('errors' => $errors));
