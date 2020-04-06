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
        $result = $this->execute($sql);
        return $result;
	}

	public function login($email, $password)
	{
		$sql1 = "SELECT password FROM user WHERE email = '$email'";
		$result1 = mysqli_query($this->connect, $sql1);
		
		if(mysqli_num_rows($result1) != 0)
		{
			$row = mysqli_fetch_assoc($result1);
			$result2 = password_verify($password, $row["password"]);
		   	return $result2;
		}
	}

	public function edit_user($fname, $lname, $email, $phone, $email_cond)
	{
		$sql = "UPDATE user SET first_name='$fname', last_name='$lname', email='$email', phone='$phone' WHERE email='$email_cond'";

		$result = $this->execute($sql);
		return $result;
	}

	public function verify_user($email)
	{
		$sql = "SELECT * FROM user WHERE email = '$email'";

		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            //echo "User already exists! <br>";
            return true;
		}
	}

	public function send_verify_mail($email)
	{
		$token = bin2hex(random_bytes(50));

        // store token in the password-reset database table against the user's email
        $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
        $results = $this->execute($sql);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Reset your password on examplesite.com";
        $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
        $msg = wordwrap($msg,70);
        $headers = "From: info@examplesite.com";
        mail($to, $subject, $msg, $headers);
        return true;
	}

	public function reset_pwd($email, $pwd)
	{
        $en_password = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password='$en_password' WHERE email='$email'";
        $result = $this->execute($sql);
        return $result;
	}
}
	

