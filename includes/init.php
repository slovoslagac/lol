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
defined('LAYOUT_PATH') ? null : define('LAYOUT_PATH', SITE_ROOT . DS . 'layouts');

//Clasess

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
require INC_PATH . DS . 'bonus.php';
require INC_PATH . DS . 'SLUsers.php';
require INC_PATH . DS . 'sellingproduct.php';
require INC_PATH . DS . 'bill.php';
require INC_PATH . DS . 'billrows.php';
require INC_PATH . DS . 'supplies.php';
require INC_PATH . DS . 'producttypes.php';
require INC_PATH . DS . 'financialoffers.php';
require INC_PATH . DS . 'transactionallog.php';
require INC_PATH . DS . 'spPrice.php';
require INC_PATH . DS . 'spDetails.php';


//Layouts

$menuLayout = LAYOUT_PATH.DS.'headerMenu.php';
$footerMenuLayout = LAYOUT_PATH.DS.'footerMenu.php';
$tableCompetitionByHero = LAYOUT_PATH.DS.'tableCompetitionByHero.php';
$tableCompetitionByUser = LAYOUT_PATH.DS.'tableCompetitionByUser.php';
$tableBonusHours = LAYOUT_PATH.DS.'tableBonusHours.php';
$tableBonusHoursNPByMonth = LAYOUT_PATH.DS.'tableBonusHoursNoPagingByMonth.php';
$tableReservations = LAYOUT_PATH.DS.'tableReservations.php';
$tableCredits = LAYOUT_PATH.DS.'tableCredits.php';

//Logs


//Variables

$appEmployeeId = 38;
