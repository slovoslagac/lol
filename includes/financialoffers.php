<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.5.2017
 * Time: 15:55
 */
class financialoffers
{
    public $userid;
    public $bonusId;
    public $numHours;
    public $numMinutes;
    public $sessionid;


    public function __construct($userid, $numHours)
    {
        $this->userid = $userid;
        $this->numHours = $numHours;
        $this->numMinutes = $numHours * 60;
        $this->bonusId = $this->calculateBonusID($numHours);
        $tmpObject = $this->getSessionId($userid);
        $this->sessionid = $tmpObject->ID;
    }

    public function calculateBonusID($val){
        $bonusOffers = array(1=>65, 3=>66, 6=>67, 10=>68, 20=>69);
        $offerId = $bonusOffers[$val];
        return $offerId;
    }

    public function getSessionId($val){
        global $conn_old;
        $sql = $conn_old->prepare("select * from financialsessions where UserId = :vl and active = 1");
        $sql->bindParam(":vl", $val);
        $sql->execute();
        $result=$sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    public function insertOffer(){
        global $conn_old;
        global $appEmployeeId;
        $sql = $conn_old->prepare("insert into financialoffers (UserId, OfferID, SessionID, TransactionID,EmployeeId,TotalPrice, StartDateTime,FixedStart, Paid, DateAdded, LastDateUsed, FirstDateUsed) values (:ui, :oi,:si, -1, :ei, 0, now(), 0, 1, now(), '1900-01-01 00:00:00', '1900-01-01 00:00:00' )");
        $sql->bindParam(":ui",$this->userid);
        $sql->bindParam(":oi",$this->bonusId);
        $sql->bindParam(":ei",$appEmployeeId);
        $sql->bindParam(":si",$this->sessionid);
        $sql->execute();
    }


}