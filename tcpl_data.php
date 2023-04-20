<?php
$servername = "89.116.179.78";
$username = "tcpl_user";
$password = "Ttcpl@123";
$dbname = "tcpl_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "connection";
?>
