<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16.3.2017
 * Time: 15:04
 */

include(join(DIRECTORY_SEPARATOR, array('..', 'includes', 'init.php')));

print_r($session);

echo "<br>";

echo $session->isLoggedIn();

echo "<br>";


if($session->isLoggedIn()){
    echo "do jaja";
} else {
    echo "ne radi";
}

echo "<br>";

$usr = new worker();
$pera = $usr->getWorkerByUsername('proske');

print_r($pera);


echo "<br>";
$session->login($pera);

print_r($session);
echo "<br>";
if($session->isLoggedIn()){
    echo "do jaja";
//    redirectTo("index.html");
} else {
    echo "ne radi";
}