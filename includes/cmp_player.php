<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 26.11.2017
 * Time: 21:10
 */
class cmp_player
{
    protected $username;
    protected $phone;
    public $email;

    public function setattribute($atr, $value){
        $this->$atr = $value;
    }

    public function setall($username,$phone,$email){
        $this->username = $username;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function addplayer()
    {
        global $conn_cmp;
        $hash = md5(rand(0,1000));
        $sql= $conn_cmp->prepare("insert into players(name, phone, email, passhash) values (:nm, :ph, :em, :hsh)");
        $sql->bindParam(":nm", $this->username);
        $sql->bindParam(":ph", $this->phone);
        $sql->bindParam(":em", $this->email);
        $sql->bindParam(":hsh", $hash);
        $sql->execute();
    }

    public function getattribute($val){
        global $conn_cmp;
        $sql= $conn_cmp->prepare("select * from players where email = :vl");
        $sql->bindParam(":vl", $val);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getall(){
        global $conn_cmp;
        $sql= $conn_cmp->prepare("select * from players order by email");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function checkpalyer ($email, $hash){
        global $conn_cmp;
        $sql= $conn_cmp->prepare("select * from players where email = :em and passhash = :hsh");
        $sql->bindParam(":em", $email);
        $sql->bindParam(":hsh", $hash);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}