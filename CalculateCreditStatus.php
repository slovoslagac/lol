<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentDate = new dateTime();
$currentMonth = $currentDate->format('n');
$month = $currentMonth -1;

$user = new user();
$bonus = new bonus;
$allBonusesCurrentMonth = $bonus->getResults($month, 20);
$tmpArray = array();
foreach ($allBonusesCurrentMonth as $item ){
    array_push($tmpArray, $item->id);
}

$tmpArray = join(",", $tmpArray);

$user->resetCreditStatus();

$user->resetCreditStatus(1,$tmpArray);

print_r($tmpArray);



























?>