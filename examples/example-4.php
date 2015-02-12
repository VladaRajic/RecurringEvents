<?php
include_once '../app/RecurringEvent.php';
?>

<h2>Event starts 01.04.2015. Repeat every weekend until 01.06.2015.</h2>

<?php

$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "DAILY", "Europe/Belgrade");
$r->setDays(array("SA", "SU"));
$r->until('2015-06-01 16:00:00');
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}

