<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();

    /*$user = new User();
    $sql = "Select * from user where email='".$_POST["email"]."'";
    echo $sql;
    $output1 = $user->SelectAll($sql);*/

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

       
        if(empty($errors) ) {

            $user = new User();

            $fname = $_POST["firstName"];
            $lname = $_POST["lastName"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            /*$sql = "Select * from user where email='$email'";
            echo $sql;
            $output1 = $user->SelectAll($sql);
            echo $output1;*/
          
            $output = $user->edit_user($fname, $lname, $email, $phone);
            if ($output) {
                $errors[] = "Upadated data successfully!";
            }
            else
            {
                $errors[] = "Error:";
            }
        }
                
    }
    
    echo $twig->display('header.html.twig');
    echo $twig->render('edit_user.html.twig', array('errors' => $errors));
   