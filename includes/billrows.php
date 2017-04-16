<?php

class billrows
{
    public function addBillRow($bid, $npr, $spr, $price)
    {
        global $conn;
        $sql = $conn->prepare("insert into billsrows ( billrid, numProducts, sellingproductpriceid, price) values (:bid, :np, :sid, :pc)");
        $sql->bindParam(":bid", $bid);
        $sql->bindParam(":np", $npr);
        $sql->bindParam(":sid", $spr);
        $sql->bindParam(":pc", $price);
        $sql->execute();

    }
}