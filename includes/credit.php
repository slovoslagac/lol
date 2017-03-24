<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.3.2017
 * Time: 9:45
 */
class credit
{
    public function getAllUserCredits()
    {
        global $conn;
        $sql = $conn->prepare("select u.id, u.arenausername username, sum(c.value) value, datediff(SYSDATE(),min(c.`timestamp`)) num_days
from users u
left join credit c on c.userid = u.id
where u.creditstatus = 1
group by u.id, u.arenausername order by value desc");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addUserCredit($user, $value, $worker)
    {
        global $conn;
        $insertNewUser = $conn->prepare("insert into credit (userid, value, workerid) values (:us, :vl, :wr)");
        $insertNewUser->bindParam(':us', $user);
        $insertNewUser->bindParam(':vl', $value);
        $insertNewUser->bindParam(':wr', $worker);
        $insertNewUser->execute();
    }

}