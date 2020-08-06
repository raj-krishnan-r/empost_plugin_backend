<?php
include('connect.php');
header('Content-Type:application/pdf');
$orderid = $_GET['orderid'];
// Create connection
$stmt = $conn->prepare("SELECT billString from awb where ordername = ?");
$orderid = '#'.$orderid;
$stmt->bind_param("s",$orderid);
$stmt->execute();

$result = $stmt->get_result();

  // output data of each row
while($row = $result->fetch_assoc()) {
  $billString = $row['billString'];
 }
echo base64_decode($billString);
$conn->close();
?> 
