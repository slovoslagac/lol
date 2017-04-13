<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 11.4.2017
 * Time: 21:50
 */
class sellingproduct
{
    public function getAllSellingProductsByType($type){
        global $conn;
        $sql = $conn->prepare("select name, value, sp.id id, sp.typeid as producttype, spp.id as sppid
from sellingproducts sp, sellingproductsprices spp
where sp.id = spp.selingproductid
and spp.pricetype = :tp order by 4 desc, 1");
        $sql->bindParam(':tp',$type);
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }


    public function getAllSellingProducts(){
        global $conn;
        $sql = $conn->prepare("select name, sp.id id, sp.typeid as producttype
from sellingproducts sp order by id ");
        $sql->bindParam(':tp',$type);
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }
}