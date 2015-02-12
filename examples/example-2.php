<?php
include_once '../app/RecurringEvent.php';
?>
<h2>Event starts 01.04.2015, ends 15.04.2015. Repeat daily</h2>

<?php

$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "DAILY", "Europe/Belgrade");
$r->until('2015-04-15 16:00:00');
$result = $r->toArray();


foreach ($result as $date){
    echo $date->format("c") . "<br>";
}