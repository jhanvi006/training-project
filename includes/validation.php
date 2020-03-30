<?php

    if(empty($_POST)) { header("location: home.php"); exit; }

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


    //Data Entry
    //require_once __DIR__ . '/database.php';
    require_once __DIR__ . "/common.php";

    $db = new database();
    $sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','".$_POST["password"]."')";
    $db->execute($sql);

    header("location: home.php"); 
?>