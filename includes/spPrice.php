<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 2.6.2017
 * Time: 13:36
 */
class spPrice
{
    public function addselingproductprice($id, $value, $type) {
        global $conn;
        $sql=$conn->prepare("insert into sellingproductsprices(selingproductid,value, pricetype) values (:id, :vl, :tp)");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":vl", $value);
        $sql->bindParam(":tp", $type);
        $sql->execute();
    }
}