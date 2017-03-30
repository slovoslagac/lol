<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:09
 */

//win DS = "\", Mac/Linux DS = "/"
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'lol');
//defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:'  . DS . 'www' . DS . 'lol');
//defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'XAMPP' . DS . 'htdocs' . DS . 'lol');
defined('INC_PATH') ? null : define('INC_PATH', SITE_ROOT . DS . 'includes');
defined('ADMIN_PATH') ? null : define('ADMIN_PATH', SITE_ROOT . DS . 'admin');


require INC_PATH . DS . 'config.php';
require INC_PATH . DS . 'db.php';
require INC_PATH . DS . 'function.php';
require INC_PATH . DS . 'hero.php';
require INC_PATH . DS . 'position.php';
require INC_PATH . DS . 'rank.php';
require INC_PATH . DS . 'result.php';
require INC_PATH . DS . 'session.php';
require INC_PATH . DS . 'user.php';
require INC_PATH . DS . 'worker.php';
require INC_PATH . DS . 'credit.php';
require INC_PATH . DS . 'reservation.php';
require INC_PATH . DS . 'pagination.php';
require INC_PATH . DS . 'info.php';
require INC_PATH . DS . 'products.php';
require INC_PATH . DS . 'suppliers.php';
require INC_PATH . DS . 'orders.php';


