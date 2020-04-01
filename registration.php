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
    
        //Show Errors, If Any
        if( ! empty($errors) ) {
            echo "<b>Error(s):</b><hr />";
            foreach($errors as $e) {
                echo $e."<br />";
            }
            //header("location: registration.php");
        }

        else{
        // Data entry
        $user = new User();

        $sql = "SELECT * FROM user WHERE email = '$_POST[email]'";
        $output = $user->user_exists($sql);
    
        if(!$output)
        {
            $first_name = mysqli_real_escape_string($this->connect, $_POST['firsNname']);
            $last_name = mysqli_real_escape_string($this->connect, $_POST['lastName']);
            $email = mysqli_real_escape_string($this->connect, $_POST['email']);
            $phone = mysqli_real_escape_string($this->connect, $_POST['phone']);
            $en_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('$first_name','$last_name','$email','$phone','$en_password')";
            //$sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','$en_password')";
            $user->execute($sql);
        }     
        }       
    }
    
    echo $twig->render('register.html.twig');
