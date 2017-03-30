<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.3.2017
 * Time: 13:31
 */
class suppliers
{
    public function getAllSuppliers(){
        global $conn;
        $sql = $conn->prepare("select name, id from suppliers order by name ");
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_OBJ);
        return $result;

    }
}