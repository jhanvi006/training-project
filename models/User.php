<?php
class User extends database 
{
	public function user_exists($email)
	{
		 $sql = "SELECT * FROM user WHERE email = '$email'";

		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "User already exists! <br>";
            return false;
		}
	}

	public function execute($fname, $lname, $email, $phone, $pwd)
	{
        $first_name = mysqli_escape_string($this->connect, $fname);
		$last_name = mysqli_escape_string($this->connect, $lname);
        $email = mysqli_escape_string($this->connect, $email);
        $phone = mysqli_escape_string($this->connect, $phone);
        $en_password = password_hash($pwd, PASSWORD_DEFAULT);
        $e_sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('$first_name','$last_name','$email','$phone','$en_password')";
        //$sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','$en_password')";
        if (mysqli_query($this->connect,$e_sql)) {
		    echo "You are registered successfully";
		    return true;
		}
	}
}
	

