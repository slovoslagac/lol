<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 20.9.2017
 * Time: 12:34
 */
class shift
{
    public $starttime;
    public $endtime;
    public $status;

    public function __construct()
    {
    }

    public function getCurrentShift(){
        global $conn;
        $sql = $conn->prepare("select * from shifts where status = 1 order by starttime limit 1");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getLastClosedShift(){
        global $conn;
        $sql = $conn->prepare("select * from shifts where status = 2 order by starttime limit 1");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function startShift($userid){
        global $conn;
        $sql = $conn->prepare("insert into shifts (starttime, status, userstart) values (now(), 1, :uid)");
        $sql->bindParam("uid", $userid);
        $sql->execute();
        logAction("Shift start ---------------------", "userid = $userid ", 'shiftDetails.txt');
    }

    public function endShift($userid, $shiftid){
        global $conn;
        $sql = $conn->prepare("update shifts set status = 2, endtime = now(), userend = :uid where id = :sid and status = 1 and userstart = :ust");
        $sql->bindParam("uid", $userid);
        $sql->bindParam("sid", $shiftid);
        $sql->bindParam("ust", $userid);
        $sql->execute();
        logAction("Shift end", "userid = $userid", 'shiftDetails.txt');
    }

}