<?php
class User extends database 
{
	public function user_exists($sql)
	{
		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "User already exists!";
            return true;
		}
		/*else{
			$sql = "INSERT INTO user(first_name, last_name, email, phone, password) VALUES('".$_POST["firstName"]."','".$_POST["lastName"]."','".$_POST["email"]."','".$_POST["phone"]."','".$_POST["password"]."')";
            $user->execute($sql);
		}*/
	}
}

