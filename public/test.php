<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:23
 */

include(join(DIRECTORY_SEPARATOR, array('..','includes', 'init.php')));

include (join(DIRECTORY_SEPARATOR, array(INC_PATH.DS.'position.php')));


$position = new position();
$obj = $position->getAllPositions();

print_r($obj);