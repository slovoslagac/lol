<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 4.4.2017
 * Time: 08:50
 */
class SLUsers
{
    public function getAllUsers(){
        global $conn_old;
        $sql = $conn_old->prepare("select Username, id from users limit 3");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}