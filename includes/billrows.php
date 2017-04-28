<?php

class billrows
{
    public function addBillRow($bid, $npr, $spr, $price, $spid)
    {
        global $conn;
        $sql = $conn->prepare("insert into billsrows ( billrid, numProducts, sellingproductpriceid, price, sellingproductid) values (:bid, :np, :sid, :pc, :spid)");
        $sql->bindParam(":bid", $bid);
        $sql->bindParam(":np", $npr);
        $sql->bindParam(":sid", $spr);
        $sql->bindParam(":pc", $price);
        $sql->bindParam(":spid", $spid);
        $sql->execute();

    }

    public function deleteRowsById($id){
        global $conn;
        $sql = $conn->prepare("delete from billsrows where billrid = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
    }
}