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