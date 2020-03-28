<?php
require_once __DIR__ . '/DB_Interface.php';

class database implements DB_interface
{
	public $connect;
	public function __construct(){
		// Create connection
		$this->connect = mysqli_connect(DB_HOST_NAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

		// Check connection
		if (!$this->connect) {
		    die("connection failed: " . mysqli_connect_error());
		}
		echo "connected successfully <br>";
	}

	public function selectAll($sql){
		//$sql = "SELECT * FROM user_detail";
		$result = mysqli_query($this->connect, $sql);

		foreach ($result as $key => $value) {
			echo "<br>";
			var_dump($value);
		}
		return $value;

		/*if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
		        echo "Username: ".$row["username"]." Email: ".$row["email"]." Contact: ".$row["mobileNo"]. "<br>";

		    }
		}*/
	}

	public function selectOne($sql){
		$sql = "SELECT * FROM user_detail WHERE LIMIT 1";
		$result = mysqli_query($this->connect, $sql);

		while($row = mysqli_fetch_assoc($result)) {
		    echo "Username: ".$row["username"]." Email: ".$row["email"]." Contact: ".$row["mobileNo"]. "<br>";
	    }
		//echo "Username: ".$row["username"]." Email: ".$row["email"]." Contact: ".$row["mobileNo"]. "<br>";
	}

	public function execute($sql){
		if (mysqli_query($this->connect,$sql)) {
		    echo "Record updated successfully";
		}
	}
}
