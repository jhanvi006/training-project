<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    
    $errors = array();
    
    $email = $_GET["email"];
    $token = $_GET["token"];

    $user = new User();
    $sql = "SELECT * FROM password_reset WHERE email='$email' LIMIT 1";
    $output = $user->SelectOne($sql);

    if ($output["token"] == $token)
    {
        $_SESSION["email"] = $email;
    }
    else
    {
        //$errors[] = "Error: Recovery email has been expired";
        echo "Error: Recovery email has been expired";
        exit;
    }
    
    echo $twig->render('reset_password.html.twig', array('errors' => $errors));
