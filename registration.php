<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";


    if(!empty($_POST)) { 
        $errors = array();

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

        //Show Errors, If Any
        if( ! empty($errors) ) {
            echo "<b>Error(s):</b><hr />";
            foreach($errors as $e) {
                echo $e."<br />";
            }
            exit;
        }
        else {
            //Data Entry
            $user = new User();

            $sql = "SELECT * FROM user WHERE email = '$_POST[email]' OR phone = '$_POST[phone]'";
            $output = $user->user_exists($sql);

            if(!$output)
            {
                $sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','".$_POST["password"]."')";
                $user->execute($sql);
            }            
        }
    }
    else {
        //header("location: home.php"); 
        echo $twig->render('register.html.twig');
    }



