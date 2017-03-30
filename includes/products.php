<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.3.2017
 * Time: 13:31
 */
class products
{
    public function getAllProducts(){
        global $conn;
        $sql = $conn->prepare("select p.name productname, pt.name producttype, p.id
from products p, producttype pt
where p.typeid = pt.id order by 2, 1");
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }
}