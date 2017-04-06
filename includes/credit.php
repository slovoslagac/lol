<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.3.2017
 * Time: 9:45
 */
class credit
{
    public $expired = 0;
    public function getSumAllUserCredits()
    {
        global $conn;
        $sql = $conn->prepare("select u.id, u.arenausername username, sum(c.value) value, datediff(SYSDATE(),min(c.`timestamp`)) num_days
from users u
left join credit c on c.userid = u.id and expired = 0
group by u.id, u.arenausername order by value desc");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getSumAllUserCreditsAvailable()
    {
        global $conn;
        $sql = $conn->prepare("select u.id, u.arenausername username, sum(c.value) value, datediff(SYSDATE(),min(c.`timestamp`)) num_days
from users u
left join credit c on c.userid = u.id and expired = 0
where creditstatus = 1
group by u.id, u.arenausername order by username ");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addUserCredit($user, $value, $worker )
    {
        global $conn;
        $insertNewUser = $conn->prepare("insert into credit (userid, value, workerid, expired) values (:us, :vl, :wr, :ex)");
        $insertNewUser->bindParam(':us', $user);
        $insertNewUser->bindParam(':vl', $value);
        $insertNewUser->bindParam(':wr', $worker);
        $insertNewUser->bindParam(':ex', $this->expired);
        $insertNewUser->execute();
    }

    public function getSumUserCredit($id){
        global $conn;
        $sql = $conn->prepare("select c.userid id, sum(c.value) value
from  credit c
where  c.userid = $id
group by c.userid ");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function creditExpire($id){
        global $conn;
        $sql = $conn->prepare("Update credit set expired = 1 where userid = $id");
        $sql->execute();
    }

}