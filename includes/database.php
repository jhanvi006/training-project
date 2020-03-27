<?php
require_once __DIR__ . '/DB_Interface.php';

class database implements DB_interface
{
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

		if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
		        echo "Username: ".$row["username"]." Email: ".$row["email"]." Contact: ".$row["mobileNo"]. "<br>";

		    }
		}
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

		//insert query
		//$sql = "INSERT INTO user_detail () VALUES ()";

		if (mysqli_query($this->connect, $sql)) {
		    echo "New record created successfully";
		}

		//update query 
		//$sql = "UPDATE user_detail SET newvalue WHERE condition";

		if (mysqli_query($this->connect,$sql)) {
		    echo "Record updated successfully";
		}

		//delete query 
		//$sql = "DELETE FROM user_detail WHERE condition";

		if (mysqli_query($this->connect, $sql)) {
		    echo "Record deleted successfully";
		}
	}
}
