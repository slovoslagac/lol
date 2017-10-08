<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 21.3.2017
 * Time: 11:47
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$currentShift = new shift();
$currentShiftDetails = $currentShift->getCurrentShift();
$wrk = new worker();
$currentWorker = $wrk->getWorkerById($session->userid);

var_dump( $currentShiftDetails);

if($currentShiftDetails == true and $currentShiftDetails->userstart == $currentWorker->id) {
    redirectTo("end_shift.php");
} else {
    $session->logout();
    redirectTo("login.php");
}