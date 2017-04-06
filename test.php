<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$user = new user;

$allusers = $user->getAllUsersLol();
$userid = $user->getUserByUsername('prole');


var_dump($userid);
var_dump($allusers);















?>