<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 30.3.2017
 * Time: 17:19
 */
class orders
{
    public function getMaxId()
    {
        global $conn;
        $sql = $conn->prepare("Select max(id) id from orders");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addOrder($date, $id)
    {
        global $conn;
        $sql = $conn->prepare("insert into orders (date, supplierid) values (:dt, :sp)");
        $sql->bindParam(':dt', $date);
        $sql->bindParam(':sp', $id);
        $sql->execute();
    }
}