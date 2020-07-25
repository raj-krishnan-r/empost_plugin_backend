<?php

echo timeFixer('21-August-2020');
function timeFixer($reference)
{
$d = date('H');
$tz = 'Asia/Dubai'; // your required location time zone.
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
//echo $dt->format('Y/m/d H:i:s');

$d1 = date_create($reference);
$d2 = date_create($dt->format('d-F-Y'));

$diff = date_diff($d1,$d2);

if(($diff->d)>0)
{
return "12:00";
}
else
{
$hour = $dt->format('H');
if(($hour+1)>18)
{
return "18:00";
}
else
{
return strval($hour+1).":00";
}
}
}
?>
