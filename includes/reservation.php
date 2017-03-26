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
        $sql = $conn->prepare("select h.name heroname, u.name uname, u.lastname ulastname, u.arenausername uusername, count(*) value
from userheroresult urh, heroes h, users u
where urh.userid = u.id
and urh.heroid = h.id
group by h.name, u.name, u.lastname, u.arenausername order by 5 desc,2,1");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

}