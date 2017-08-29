<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.3.2017
 * Time: 13:31
 */
class products
{
    public $name;
    public $type;

    public function __construct($name ='', $type='')
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getAllProducts(){
        global $conn;
        $sql = $conn->prepare("select p.name productname, pt.name producttype, p.id
from products p, producttype pt
where p.typeid = pt.id order by 2, 1");
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }


    public function addNewProduct() {
        global $conn;
        $sql = $conn->prepare("insert into products (name, typeid) values (:nm, :tp)");
        $sql->bindParam(":nm", $this->name);
        $sql->bindParam(":tp", $this->type);
        $sql->execute();
    }


    public function checkProduct(){
        global $conn;
        $sql = $conn->prepare("select * from products where name = :nm and typeid = :tp");
        $sql->bindParam(":nm", $this->name);
        $sql->bindParam(":tp", $this->type);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

}