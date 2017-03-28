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

$nextBonus = array(0=>30,1=>60,3=>90, 6=>120, 10=> 150, 20=>180);
