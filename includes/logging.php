<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 23.3.2017
 * Time: 17:36
 */

if (!$session->isLoggedIn()) {
    redirectTo("login.php");
}

if (isset($_POST["logout"])) {
    echo "Izlogovali smo se <br>";
    $session->logout();
    redirectTo("login.php");
}


$wrk = new worker();
$currentWorker = $wrk->getWorkerById($session->userid);