<?php

/**
 * Created by PhpStorm.
 * User: petar.prodanovic
 * Date: 14.3.2017.
 * Time: 15.32
 */
class result
{
    private $userid;
    private $heroid;

    public function getSumResult()
    {
        global $conn;
        $sql = $conn->prepare("select h.name heroname, u.name uname, u.lastname ulastname, u.arenausername uusername, count(*) value
from userheroresult urh, heroes h, users u
where urh.userid = u.id
and urh.heroid = h.id
group by h.name, u.name, u.lastname, u.arenausername order by 5,2,1");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getAllResults($time = '')
    {
        global $conn;
        if ($time != '') {
            $sql = $conn->prepare("select * h.name heroname, u.name uname, u.lastname ulastname, u.arenausername uusername from userheroresult urh, heroes h, users u
where urh.userid = u.id
and urh.heroid = h.id
and timestamp > sysdate - interval $time MINUTE ");
        }
        $sql = execute();
    }

    public function insertResult($user, $hero, $date, $time)
    {
        global $conn;
        $insertNewResult = $conn->prepare("insert into userheroresult (userid, heroid, matchdate, matchtime) values (:ui, :hi, :dt, :tm)");
        $insertNewResult->bindParam(':ui', $user);
        $insertNewResult->bindParam(':hi', $hero);
        $insertNewResult->bindParam(':dt', $date);
        $insertNewResult->bindParam(':tm', $time);
        $insertNewResult->execute();
    }

    public function deleteResult($id)
    {
        global $conn;
        $deleteResult = $conn->prepare("delete from userheroresult where id = :id");
        $deleteResult->bindParam(':id', $id);
        $deleteResult->execute();
    }

}