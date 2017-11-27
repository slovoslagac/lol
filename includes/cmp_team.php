<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 26.11.2017
 * Time: 21:10
 */
class cmp_team
{
    protected $username;
    protected $phone;
    public $email;

    public function setattribute($atr, $value){
        $this->$atr = $value;
    }

    public function addteam()
    {
        global $conn_cmp;
        $sql= $conn_cmp->prepare("insert into teams(name, phone, email) values (:nm, :ph, :em)");
        $sql->bindParam(":nm", $this->username);
        $sql->bindParam(":ph", $this->phone);
        $sql->bindParam(":em", $this->email);
        $sql->execute();
    }

    public function getattribute($val){
        global $conn_cmp;
        $sql= $conn_cmp->prepare("select * from teams where email = :vl");
        $sql->bindParam(":vl", $val);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getall(){
        global $conn_cmp;
        $sql= $conn_cmp->prepare("select * from teams order by email");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}