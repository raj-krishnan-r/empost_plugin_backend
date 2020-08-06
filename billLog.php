<?php
require('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>
Envelope of Scale
</title>
</head>
<body>
<h1>Bill log</h1>
<table style="border:1px dotted black;">
<thead>
<tr><th>Order name</th><th>Time +4:00</th><th>Time +5:30</th></tr>
</thead>
<tbody>
<?php
$stmt = $conn->prepare("SELECT ordername,dated from awb order by dated DESC");
  // output data of each row
$stmt->execute();
$result = $stmt->get_result();
  while($row = $result->fetch_assoc()) {
     $url = substr($row['ordername'],1);
    echo '<tr style="border:1px dotted black;"><td style="border:1px dotted black;"><a href="getBill.php?orderid='.$url.'">'.$row['ordername'].'</a></td>';
    echo '<td style="border:1px dotted black;">'.dateFormatter($row['dated'],'d-F-Y H:m:i','Asia/Dubai').'</td>';
    echo '<td style="border:1px dotted black;">'.dateFormatter($row['dated'],'d-F-Y H:m:i','Asia/Calcutta').'</td></tr>';

 }



$conn->close();

function dateFormatter($datetime,$format,$timezone)
{
$gmt = new DateTimeZone('GMT');
$server = new DateTime($datetime,$gmt);

$user = new DateTimeZone($timezone);
$offset = $user->getOffset($server);

$myinterval = DateInterval::createFromDateString((string)$offset . 'seconds');
$server->add($myinterval);
$result = $server->format($format);
return $result;
}
?> 
</tbody>
</body>
</html>
