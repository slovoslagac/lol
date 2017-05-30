<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.5.2017
 * Time: 14:14
 */
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$newbonus = new bonus();
$MonthlyBonusList = $newbonus->getMonthlyBonusObjects(3);
$i=1;
$allFinancialOffers = array();


foreach($MonthlyBonusList as $item){
    if($item->numHours > 0) {
    $tmpOffer = new financialoffers($item->SLuserId, $item->numHours);
    array_push($allFinancialOffers, $tmpOffer);
}}


foreach($allFinancialOffers as $item) {
    echo "$item->userid - $item->numHours($item->numMinutes) - $item->bonusId<br>";
}