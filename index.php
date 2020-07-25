<?php
$recieved = $_POST['datum'];
$decoded = (json_decode($recieved));
foreach($decoded->items as $item)
{
    echo "<br>".$item->id;
}
?>