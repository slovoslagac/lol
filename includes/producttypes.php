<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 26.5.2017
 * Time: 20:51
 */
class producttypes
{
    public function getAllProductTypes(){
        global $conn;
        $sql = $conn->prepare("select * from producttype");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}