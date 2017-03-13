<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:09
 */

//win DS = "\", Mac/Linux DS = "/"
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'AppServ' . DS . 'www' . DS . 'lol');
//defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'XAMPP' . DS . 'htdocs' . DS . 'lol');
defined('ADMIN_PATH') ? null : define('ADMIN_PATH', SITE_ROOT .  DS . 'includes');


require ADMIN_PATH . DS . 'config.php';
require ADMIN_PATH . DS . 'position.php';