<?php

class billrows
{
    public function addBillRow($bid, $npr, $spr, $price, $spid, $type)
    {
        global $conn;
        $sql = $conn->prepare("insert into billsrows ( billrid, numProducts, sellingproductpriceid, price, sellingproductid, type) values (:bid, :np, :sid, :pc, :spid, :tp)");
        $sql->bindParam(":bid", $bid);
        $sql->bindParam(":np", $npr);
        $sql->bindParam(":sid", $spr);
        $sql->bindParam(":pc", $price);
        $sql->bindParam(":spid", $spid);
        $sql->bindParam(":tp", $type);
        $sql->execute();

    }

    public function deleteRowsById($id){
        global $conn;
        $sql = $conn->prepare("delete from billsrows where billrid = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
    }
}