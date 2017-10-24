<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.10.2017
 * Time: 15:07
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

if(isset($_SESSION['details'])) {

    foreach ($_SESSION['details'] as $arr) {
        print_r($arr) . "<br />";

    }
}