<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$SonyArray = array();
$now = new DateTime();
global $numSony;
for ($i = 1; $i <= $numSony; $i++) {
    echo " $i <br>";
    $tmpSony = getSonyTime($i);
    $lasttime = 0;
    var_dump($tmpSony);
    echo "<br>";
    foreach ($tmpSony as $item) {
        $tmptime = new DateTime("$item->tstamp");
        if ($lasttime == '') {
            $starttime = $tmptime;
        } else {
            ($lasttime > $tmptime) ? $starttime = $lasttime : $starttime = $tmptime;
        }

        echo "$item->value, <br>";
        $timeaddval = 'PT' . $item->value . 'M';
        $endtime = $starttime->add(new DateInterval($timeaddval));

            $lasttime = $endtime;

        echo "$timeaddval," . $endtime->format('M d, Y H:i:s');
        "<br>";
    }

    if ($lasttime != null) {
        $SonyArray[$i] = $lasttime->format('M d, Y H:i:s');
    }

    echo "<br>";
}

//    return $SonyArray;

echo "<br>";
print_r($SonyArray);