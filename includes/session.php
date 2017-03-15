<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.3.2017
 * Time: 14:04
 */
class session
{
    private $loggedin = false;
    public $userid;

    public function __construct()
    {
        session_start();
        $this->loggedin;
    }

    public function is_logged_in () {
        return $this->loggedin;
    }

    private function chechk_login(){
        if(isset($_SESSION["user_id"])){
            $this->userid = $_SESSION["user_id"];
            $this->loggedin = true;
        } else {
            unset($user_id);
            $this->loggedin = false;
        }
    }
}

$session = new session();