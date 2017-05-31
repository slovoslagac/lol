<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.5.2017
 * Time: 14:14
 */
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

try {
$tmp = new financialoffers(28330,20);
$tmp->insertOffer();
} catch (Exception $e) {
    logAction("insert - error", "$e", 'error.txt');
}