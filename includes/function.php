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
