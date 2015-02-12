# RecurringEvents

#Examples

<h3>Example 1</h3>

Event starts 01.04.2015. Repeat weekly. Limit is 11 repetitions

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "WEEKLY", "Europe/Belgrade");
$r->setRepetition(11);
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
```
<h3>Example 2</h3>

Event starts 01.04.2015, ends 15.04.2015. Repeat daily

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "DAILY", "Europe/Belgrade");
$r->until('2015-04-15 16:00:00');
$result = $r->toArray();


foreach ($result as $date){
    echo $date->format("c") . "<br>";
```

<h3>Example 3</h3>

Event starts 01.04.2015. Repeat monday-wednesday-friday. No limit

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "MWF", "Europe/Belgrade");
$result = $r->toArray();


foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
```

<h3>Example 4</h3>

Event starts 01.04.2015. Repeat every weekend until 01.06.2015.

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "DAILY", "Europe/Belgrade");
$r->setDays(array("SA", "SU"));
$r->until('2015-06-01 16:00:00');
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
```

<h3>Example 5</h3>

Event starts 01.04.2015. Repeat monday-wednesday-friday every two weeks, until 01.06.2015.

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "MWF", "Europe/Belgrade");
$r->setInterval(2);
$r->until('2015-06-01 16:00:00');
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
```

<h3>Example 6</h3>

Event starts 01.04.2015. Repeat monthly, until 01.12.2015.

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "MONTHLY", "Europe/Belgrade");
$r->until('2015-12-01 16:00:00');
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
```

<h3>Example 7</h3>

Event starts 01.04.2015. Repeat yearly, no limits.

```
$r = new RecurringEvent();
$r->recurr('2015-04-01 16:00:00', "YEARLY", "Europe/Belgrade");
$result = $r->toArray();

foreach ($result as $date){
    echo $date->format("c") . "<br>";
}
```