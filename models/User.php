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

	public function insert_user($fname, $lname, $email, $phone, $pwd)
	{
		$first_name = mysqli_escape_string($this->connect, $fname);
		$last_name = mysqli_escape_string($this->connect, $lname);
        $email = mysqli_escape_string($this->connect, $email);
        $phone = mysqli_escape_string($this->connect, $phone);
        $en_password = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('$first_name','$last_name','$email','$phone','$en_password')";
        //$sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','$en_password')";
        if (mysqli_query($this->connect,$sql)) {
		    //echo "You are registered successfully";
		    return true;
		}
	}

	public function login($email, $password)
	{
		$sql1 = "SELECT password FROM user WHERE email = '$email'";
		$result1 = mysqli_query($this->connect, $sql1);
		var_dump($result1);
		echo "<br>";
		if(mysqli_num_rows($result1) != 0)
		{
			$row = mysqli_fetch_assoc($result1);
			$result2 = password_verify($password, $row["password"]);
		   	return $result2;
		}
	}
}
	

