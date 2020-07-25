<?php
header('Content-Type:application/pdf');
$servername = "localhost";
$username = "id14351568_raj";
$password = "8Countries@world";
$dbname = "id14351568_essentials";
$orderid = $_GET['orderid'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT billString from awb where ordername = '#$orderid'";
$result = $conn->query($sql);
  // output data of each row
 while($row = $result->fetch_assoc()) {
$billString = $row['billString'];
 }
echo base64_decode($billString);
$conn->close();
?> 
