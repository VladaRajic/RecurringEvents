<?php
include_once '../app/RecurringEvent.php';
?>

<h2>Event starts 01.04.2015. Repeat yearly, no limits.</h2>

<?php

$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "YEARLY", "Europe/Belgrade");
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}

