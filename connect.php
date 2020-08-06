<?php
$servername = "localhost";
$username = "id14351568_raj";
$password = "8Countries@world";
$dbname = "id14351568_essentials";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>