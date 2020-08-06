<?php
$ip = "2020-07-29 15:01:54";
$gmt = new DateTimeZone('GMT');
$server = new DateTime($ip,$gmt);

$user = new DateTimeZone('Asia/Dubai');
$offset = $user->getOffset($server);

$myinterval = DateInterval::createFromDateString((string)$offset . 'seconds');
$server->add($myinterval);
$result = $server->format('Y-m-d H:i:s');
echo $result;
?>
