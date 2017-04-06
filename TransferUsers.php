<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 4.4.2017
 * Time: 15:43
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

logAction("Transfer poceo", "", 'UserTransfer.txt');
$u = new user();
$maxId = $u->getLastSlId();
$allUsers = $u->getAllUsers();
$tmpArray = array();
foreach ($allUsers as $item) {
    array_push($tmpArray, $item->SLuserId);
}


$sluser = new SLUsers();
$allSlUsers = $sluser->getAllUsers();
$i=0;

foreach ($allSlUsers as $item) {
    if (!in_array($item->id, $tmpArray)) {
        try {
            $u->transferUsers($item->Username, $item->id);
            $i++;
        } catch (Exception $e) {
            logAction("Neuspesan insert usera", "userid = $item->Username, $item->id --- $e", 'error.txt');
        }
    }
}

logAction("Transfer yavrsen", "Prebaceno ukupno $i usera Novih", 'UserTransfer.txt');


unset($u);
