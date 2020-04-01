<?php
class User extends database 
{
	public function user_exists($sql)
	{
		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "User already exists! <br>";
            return true;
		}
	}
}

