<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 21.9.2017
 * Time: 13:33
 */

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmparray = array();

$tmparray[0]["num"] = -1;
$tmparray[0]["id"] = 4;
$tmparray[0]["type"] = 0;

array_push($tmparray, array('num' => -1, "id" => 9, "type" => 0));

array_push($tmparray, array('num' => 6, "id" => 10, "type" => 0));


$_POST['details'] = $tmparray;
$_POST['billstatus'] = -1000;

redirectTo("test3.php");
?>


