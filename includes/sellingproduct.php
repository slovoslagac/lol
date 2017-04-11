<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 11.4.2017
 * Time: 21:50
 */
class sellingproduct
{
    public function getAllSellingProducts($type){
        global $conn;
        $sql = $conn->prepare("select name, value, sp.id id, sp.typeid as producttype
from sellingproducts sp, sellingproductsprices spp
where sp.id = spp.selingproductid
and spp.pricetype = :tp order by 4 desc, 1");
        $sql->bindParam(':tp',$type);
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }
}