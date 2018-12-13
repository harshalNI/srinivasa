<?php
/*$servername = "localhost";
$username = "finball";
$password = "finball@123";
$dbname = "finball";*/

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "finball";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
$conn->set_charset("utf8");
?>
