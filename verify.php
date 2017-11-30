<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.11.2017
 * Time: 13:36
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    $email = $_GET['email'];
    $hash = $_GET['hash'];
    $tmpplayer = new cmp_player();
    $newplayer = $tmpplayer->checkpalyer($email, $hash);

    var_dump($newplayer);
}else{
    // Invalid approach
}