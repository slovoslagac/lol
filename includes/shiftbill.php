<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 9.10.2017
 * Time: 0:30
 */
class shiftbill
{
    public function addshiftbill($shiftid, $billid) {
        global $conn;
        $sql = $conn ->prepare("insert into shiftbill (shiftid, billid) values (:sid, :bid)");
        $sql->bindParam(":sid", $shiftid);
        $sql->bindParam(":bid", $billid);
        $sql->execute();
    }
}