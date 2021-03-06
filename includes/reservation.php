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

    public function confirmReservation($id, $wrk){
        global $conn;
        $sql=$conn->prepare("update reservations set confirmed = 1, confirmworkerid = :wk where id = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->bindParam(':wk', $wrk, PDO::PARAM_INT);
        $sql->execute();
    }

    public function cancelReservation($id, $wrk){
        global $conn;
        $sql=$conn->prepare("update reservations set confirmed = 2, confirmworkerid = :wk where id = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->bindParam(':wk', $wrk, PDO::PARAM_INT);
        $sql->execute();
    }

    public function addReservation($timedate, $computers, $user, $worker){
        global $conn;
        $addRes=$conn->prepare("insert into reservations(timedate, computers, userid, workerid) values(:td, :cp, :us, :wr);");
        $addRes->bindParam(':td', $timedate);
        $addRes->bindParam(':cp', $computers);
        $addRes->bindParam(':us', $user);
        $addRes->bindParam(':wr', $worker);
        $addRes->execute();
    }
}