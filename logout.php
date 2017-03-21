<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 21.3.2017
 * Time: 11:47
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$session->logout();
redirectTo("login.php");