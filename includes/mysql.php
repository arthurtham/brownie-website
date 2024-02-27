<?php

require_once(".env.php");

$servername = $_environmental_variables["servername"];
$username = $_environmental_variables["username"];
$password = "";//$_environmental_variables["password"];
$dbname = $_environmental_variables["dbname"];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	header("HTTP/1.0 500 Internal Server Error");
	die();
	// die("Connection failed: " . $conn->connect_error);
}
?>