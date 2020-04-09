<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . "/includes/common.php";
    require_once __DIR__ . "/models/User.php";

    $errors = array();

    if(!empty($_SESSION["email"]))
    {
        $user = new User();
        $sql = "Select * from user where email='".$_SESSION["email"]."'";
        $output = $user->SelectOne($sql);
        
        if(!empty($_POST))
        {

            if(empty($_POST["old_password"]))
                $errors[] = "Error: Old Password is empty!";
            elseif (!password_verify($_POST["old_password"], $output["password"])) {
                $errors[] = "Error: Old password is incorrect!";
            }

            if(empty($_POST["new_password"]))
                $errors[] = "Error: New Password is empty!";
            elseif ($_POST["new_password"] == $_POST["old_password"]) {
                $errors[] = "Error: New password cannot be same as old password!";
            }

            if(empty($_POST["conf_password"]))
                $errors[] = "Error: Retype Password is empty!";
            elseif ($_POST["new_password"] != $_POST["conf_password"]) {
                $errors[] = "Error: Password does not match!";
            }
        
            if(empty($errors))
            {
                $email = $output["email"];
                $update = $user->reset_pwd($email, $_POST["new_password"]);
                if ($update) {
                    $errors[] = "Password changed successfully!";
                }
                else
                {
                    $errors[] = "Error:";
                }
            }
        }
        
        echo $twig->render('change_password.html.twig', ['output' => $output, 'errors' => $errors]);
    }
    else
    {
        echo "You are not allowed to access the page!";
    }
   