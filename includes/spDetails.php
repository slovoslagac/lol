<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 2.6.2017
 * Time: 13:57
 */
class spDetails
{
    public function addSPdetail($quantity, $prodid, $spprodid){
        global $conn;
        $sql= $conn->prepare("insert into sellingproductsdetails (quantity,productid,selingproductid) values (:qt, :pd, :spd)");
        $sql->bindParam(":qt", $quantity);
        $sql->bindParam(":pd", $prodid);
        $sql->bindParam(":spd", $spprodid);
        $sql->execute();
    }

}