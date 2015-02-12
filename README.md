# RecurringEvents

#Examples

Example 1

Event starts 01.04.2015. Repeat weekly. Limit is 11 repetitions

$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "WEEKLY", "Europe/Belgrade");
$r->setRepetition(11);
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
