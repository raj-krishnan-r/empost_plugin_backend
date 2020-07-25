
<!DOCTYPE html>
<html>
<head>
<title>
Envelope of Scale
</title>
</head>
<body>
<h1>Bill log</h1>
<h3>Last 50</h3>
<table>
<thead>
<th><td>Order name</td></th>
</thead>
<tbody>
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
$sql = "SELECT ordername from awb order by dated DESC limit 50";
$result = $conn->query($sql);
  // output data of each row
 while($row = $result->fetch_assoc()) {
     $url = substr($row['ordername'],1);
    echo '<tr><td><a href="http://cdnpwave.000webhostapp.com/getBill.php?orderid='.$url.'">'.$row['ordername'].'</a></td></tr>'; 
 }
$conn->close();
?> 
</tbody>
</body>
</html>
