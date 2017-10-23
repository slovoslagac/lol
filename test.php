<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$now = new DateTime();
var_dump($now);
echo "<br>";
for ($i = 1; $i <= $numSony; $i++) {
    $tmpSony = getSonyTime($i);
    $lasttime = '';
    echo "$i<br>";


    foreach ($tmpSony as $item) {
        var_dump($item);
        echo "<br>";
        var_dump($lasttime);
        echo "<br>";


        $tmptime = new DateTime("$item->tstamp");
        if ($lasttime == '') {$starttime = $tmptime; } else {($lasttime > $now) ? $starttime = $lasttime : $starttime = $now ;}

        $timeaddval = 'PT'.$item->value.'M';
        $endtime = $starttime->add(new DateInterval($timeaddval));
        var_dump($tmptime);
        echo "<br>";
        var_dump($starttime);
        echo "<br>";
        var_dump($endtime);
        echo "<br>";

        $lasttime = $endtime;
        echo $lasttime->format('d.m.Y H:i:s') .'<br>'. $starttime->format('d.m.Y H:i:s') .'<br>'. $endtime->format('d.m.Y H:i:s');

        echo "<br>";
    }
}