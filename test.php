<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

for ($i = 1; $i<= $numSony; $i++) {
    $tmpSony = getSonyTime($i);
    foreach($tmpSony as $item) {
    var_dump($item);
    echo"<br>";
    echo strtotime($item->tstamp) + $item->value;
    echo"<br>";
}}