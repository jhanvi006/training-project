<?php
class User extends database 
{
	public function user_exists($email)
	{
		$sql = "SELECT * FROM user WHERE email = '$email'";

		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            //echo "User already exists! <br>";
            return true;
		}
	}

	public function execute($sql)
	{
        $first_name = mysqli_escape_string($this->connect, $_POST["firstName"]);
		$last_name = mysqli_escape_string($this->connect, $_POST["lastName"]);
        $email = mysqli_escape_string($this->connect, $_POST["email"]);
        $phone = mysqli_escape_string($this->connect, $_POST["phone"]);
        $en_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $e_sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('$first_name','$last_name','$email','$phone','$en_password')";
        //$sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','$en_password')";
        if (mysqli_query($this->connect,$e_sql)) {
		    //echo "You are registered successfully";
		    return true;
		}
	}
}
	

