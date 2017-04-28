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
    private $sessionTime;
    public $sessionExpire = 28800;

    public function __construct()
    {
        session_start();
        $this->checkLogin();

    }

    public function setSessionTime()
    {
        $this->sessionTime = $_SESSION["time"] = time();
    }

    public function getSessionTime()
    {
        if(!isset($_SESSION["time"])) {
            return time();
        } else {
            return $_SESSION["time"];
        }
    }

    public function checkSessionTime()
    {
        if ($this->getSessionTime()  < time() - $this->sessionExpire) {
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedIn()
    {
        if ($this->checkSessionTime() == true) {
            $this->logout();
        } else {
            $this->setSessionTime();
            return $this->loggedin;
        }
    }


    public function login($user)
    {
        if ($user) {
            $this->loggedin = true;
            $this->userid = $_SESSION["userid"] = $user->id;
            $this->setSessionTime();
            logAction("Login", "userid = $this->userid", 'workerLogin.txt');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->loggedin = false;
        logAction("Logout", "userid = $this->userid", 'workerLogin.txt');
    }

    private function checkLogin()
    {
        if (isset($_SESSION["userid"])) {
            $this->userid = $_SESSION["userid"];
            $this->loggedin = true;
        } else {
            unset($user_id);
            $this->loggedin = false;
        }
    }


}

$session = new session();