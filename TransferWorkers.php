<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 4.4.2017
 * Time: 15:43
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

logAction("Transfer radnika poceo", "", 'UserTransfer.txt');

$user = new user();
$wrk = new worker();
$allwrk = $wrk->getAllWorkers();
$i = 0;
foreach ($allwrk as $item) {
       try {
           $username = $item->email;
            $user->transferWorkers($username);

        } catch (Exception $e) {
            logAction("Neuspesan insert radnika", "userid = $item->email, $item->id --- $e", 'error.txt');
        }
        $i++;
}

logAction("Transfer radnika zavrsen", "Prebaceno ukupno $i usera Novih", 'UserTransfer.txt');


