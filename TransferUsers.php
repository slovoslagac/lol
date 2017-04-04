<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 4.4.2017
 * Time: 15:43
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$sluser = new SLUsers();
$allSlUsers = $sluser->getAllUsers();


//foreach ($allSlUsers as $item){
//    echo "$item->id $item->Username <br>";
//    $u = new user();
//    $u->transferUsers($item->Username, $item->id);
//    unset($u);
//}

$u = new user();
$u->transferUsers('dzoni1', 29019);