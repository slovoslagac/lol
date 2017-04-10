<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16.3.2017
 * Time: 13:01
 */

function redirectTo($location = null) {
    if($location != null) {
        header("Location:{$location}");
        exit;
    }
}


if (!function_exists('password_verify')){
    function password_verify($password, $hash){
        return (crypt($password, $hash) === $hash);
    }
}


function countBonus($val){
    if($val < 30) {
        return 0;
    } elseif ($val < 60) {
        return 1;
    } elseif ($val <90) {
        return 3 ;
    } elseif ($val <120) {
        return 6;
    } elseif($val <150) {
        return 10;
    } else {
        return 20;
    }
}




function nextBonus($val) {
    $date = new DateTime();
    $day = $date->format('j');
    $sumDays = $date->format('t');
    $result = round($val/$day * $sumDays);

    return $result;
}

function logAction($action, $message, $file = 'log.txt')
{
    $logfile = SITE_ROOT . DS . 'log' . DS . $file;

    if ($handle = fopen($logfile, 'a')) {
        $timestamp = strftime("%d.%m.%Y %H:%M:%S", time());
        $content = "$timestamp | $action : $message\n";
        fwrite($handle, $content);
        fclose($handle);
    } else {
        echo "Nije uspelo logovanje";
    }
}


function cmp($a, $b){
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

function monthName($val){
    $monthArray = array(1=>"JANUAR",2=>"FEBRUAR", 3=>"MART", 4=>"APRIL", 5=>"MAJ", 6=>"JUN", 7=>"JUL", 8=>"AVGUST", 9=>"SEPTEMBAR", 10=>"oKTOBAR", 11=>"NOVEMBAR", 12=>"DECEMBAR");
    return $monthArray[$val];
}