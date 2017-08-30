<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.8.2017
 * Time: 14:19
 */
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$currentDate = new dateTime();
$currentMonth = $currentDate->format('n');
$month = $currentMonth - 1;



logAction("Obracunavam bonus za mesec", "$month", 'monthlyCalculation.txt');

//Kalkulisanje bonusa za prethodni mesec.

$bonus = new bonus;
$allBonusesCurrentMonth = $bonus->getResults($month);
$bonus->deleteMonthlyValues($month);
foreach ($allBonusesCurrentMonth as $item) {
    $hour = $item->this_month;
    if ($hour > 0) {
        $bonus->addMonthlyValues(countBonus($hour), $item->id, $month);
    }
}

logAction("Obracunavam status credita za", "$month mesec", 'monthlyCalculation.txt');

//Update credit statusa

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

logAction("Dodajem bonus sate na osnovu obracuna za ", "$month mesec", 'monthlyCalculation.txt');

//Dodavanje bonus sati u smartlaunch.

$tmpLog = new transactionallog($month, 1);
$tmpLogData = $tmpLog->checkMonthLog();

if($tmpLogData != '') {
    echo "Vec su uneti podaci za taj mesec!!!";
} else {
    $tmpLog->addMonthLog();
    $newbonus = new bonus();
    $MonthlyBonusList = $newbonus->getMonthlyBonusObjects($month);
    $i = 1;
    $allFinancialOffers = array();
    foreach ($MonthlyBonusList as $item) {
        if ($item->numHours > 0) {
            $tmpOffer = new financialoffers($item->SLuserId, $item->numHours);
            $tmpOffer->insertOffer();
            logAction("ubacen bonus za", "$item->SLuserId, $item->numHours", 'monthlyCalculation.txt');
        }
    }
}

