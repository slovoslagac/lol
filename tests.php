<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 21.9.2017
 * Time: 13:33
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmpShift = new shift();

$tmpShift->endShift(5,4);


if ($tmpShift->getCurrentShift() != '') {
} else {
    $tmpShift->startShift(3);
}
var_dump($tmpShift->getCurrentShift());
echo "<br>";
$currentShift = $tmpShift->getLastClosedShift();
var_dump($currentShift);
