<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 31.5.2017
 * Time: 22:58
 */
class transactionallog
{
    public $month;
    public $type;
    public $comment;

    public function __construct($month, $type, $comment ='')
    {
        $this->comment = $comment;
        $this->type = $type;
        $this->month = $month;
    }

    public function checkMonthLog(){
        global $conn;
        $sql = $conn->prepare("select * from transactionallog where monthid = :mt");
        $sql->bindParam(":mt", $this->month);
        $sql->execute();
        $result=$sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addMonthLog(){
        global $conn;
        $sql = $conn->prepare("insert into transactionallog (monthid, logtype, comment ) values (:mt, :lg, :cm)");
        $sql->bindParam(":mt", $this->month);
        $sql->bindParam(":lg", $this->type);
        $sql->bindParam(":cm", $this->comment);
        $sql->execute();
    }
}