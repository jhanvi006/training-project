<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

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
		//echo "connected successfully <br>";
	}

	public function selectAll($sql){
		//$sql = "SELECT * FROM user_detail";
		$result = mysqli_query($this->connect, $sql);
		// echo "result: ";
		// var_dump(mysqli_num_rows($result));
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
			//$row = mysqli_fetch_assoc($result);
		}
		return $row;
	}

	public function selectOne($sql){
		$result = mysqli_query($this->connect, $sql);

		$row = mysqli_fetch_assoc($result);
	    return $row;
	}

	public function execute($sql){
		if (mysqli_query($this->connect,$sql)) {
		    //echo "You are registered successfully";
		    return true;
		}
		else 
			echo mysqli_error($this->connect);
	}
}

