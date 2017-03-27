<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 25.3.2017
 * Time: 18:41
 */
class reservation
{
    public function getAllReservations()
    {
        global $conn;
        $sql = $conn->prepare("select u.arenausername username, date_format(r.timedate, '%d.%m') as date, date_format(r.timedate, '%H:%i') as time, r.computers as reservation, r.id, r.timedate as timedate, r.confirmed
from reservations r, users u
where r.userid = u.id order by timedate");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function confirmReservation($id){
        global $conn;
    }
}