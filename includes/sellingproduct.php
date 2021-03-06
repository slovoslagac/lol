<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 11.4.2017
 * Time: 21:50
 */
class sellingproduct
{

    public $name;
    public $typeid;


    public function __construct($name = '', $type = '')
    {
        $this->name = $name;
        $this->typeid = $type;
    }

    public function getAllSellingProductsByPriceTypeCheckSum($type)
    {
        global $conn;
        $sql = $conn->prepare("select a.name, spp.value, a.id id, a.producttype producttype, spp.id as sppid, spd.productid
from
(
select sp.id, sp.name, sp.typeid producttype
from sellingproducts sp, sellingproductsdetails spd
where sp.id = spd.selingproductid
and sp.typeid in (1,2,3)
group by sp.id, sp.name, sp.typeid
having count(*) = 1 ) a,
sellingproductsprices spp, sellingproductsdetails spd
where a.id = spp.selingproductid
and a.id = spd.selingproductid
and spp.pricetype = :tp
order by 4,1");
        $sql->bindParam(':tp', $type);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }



    public function getAllSellingProductsByPriceType($type)
    {
        global $conn;
        $sql = $conn->prepare("select name, value, sp.id id, sp.typeid as producttype, spp.id as sppid
from sellingproducts sp, sellingproductsprices spp
where sp.id = spp.selingproductid
and spp.pricetype = :tp order by 4 desc, 1");
        $sql->bindParam(':tp', $type);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }

    public function getAllSellingProductsByType($pricetype, $type)
    {
        global $conn;
        $sql = $conn->prepare("select name, value, sp.id id, sp.typeid as producttype, spp.id as sppid
from sellingproducts sp, sellingproductsprices spp
where sp.id = spp.selingproductid
and spp.pricetype = :ptp
and sp.typeid = :tp order by 4 desc, 1");
        $sql->bindParam(':tp', $type);
        $sql->bindParam(':ptp', $pricetype);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }


    public function getAllSellingProducts()
    {
        global $conn;
        $sql = $conn->prepare("select name, sp.id id, sp.typeid as producttype
from sellingproducts sp order by id ");
        $sql->bindParam(':tp', $type);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }

    public function addNewSellingProduct()
    {
        global $conn;
        $sql = $conn->prepare("insert into sellingproducts (name, typeid ) values (:nm, :tp)");
        $sql->bindParam(":nm",$this->name);
        $sql->bindParam(":tp",$this->typeid);
        $sql->execute();
    }

    public function getSellingProductByName()
    {
        global $conn;
        $sql= $conn->prepare("select * from sellingproducts where name = :nm ");
        $sql->bindParam(":nm", $this->name);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}