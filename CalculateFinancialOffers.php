<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.5.2017
 * Time: 14:14
 */
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$month = 5;

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
        }
    }
}




