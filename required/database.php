<?php
	$host = "localhost";
	$user = "root";
	$password = "test";
	$db = "rush";

	$mysqli = mysqli_connect($host, $user, $password, $db);

	if (mysqli_connect_errno($mysqli)) {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>