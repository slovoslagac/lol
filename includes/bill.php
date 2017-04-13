<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.4.2017
 * Time: 12:29
 */
class bill
{
    public $id;

    public function getLastBillsByUser($limit = 3, $wrk='') {
        global $conn;
        $sql = $conn->prepare("select * from bills where workerid = :us order by tstamp desc limit :lt");
        $sql->bindParam(":lt", $limit);
        $sql->bindParam(":us", $wrk);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getLastBill($limit = 1) {
        global $conn;
        $sql = $conn->prepare("select * from bills order by tstamp desc limit :lt");
        $sql->bindParam(":lt", $limit);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addBill($wrkid, $usrid, $bils, $prty) {
        global $conn;
        $sql = $conn->prepare("insert into bills ( workerid, userid, billsum, pricetype) values (:wr, :us, :bs, :pt)");
        $sql->bindParam(':wr', $wrkid);
        $sql->bindParam(':us', $usrid);
        $sql->bindParam(':bs', $bils);
        $sql->bindParam(':pt', $prty);
        $sql->execute();
    }
}