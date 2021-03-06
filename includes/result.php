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


    public function getSumResultByHero($limit = 10000)
    {
        global $conn;
        $sql = $conn->prepare("select h.name heroname, u.name uname, u.lastname ulastname, u.arenausername uusername, count(*) value
from userheroresult urh, heroes h, users u
where urh.userid = u.id
and urh.heroid = h.id
group by h.name, u.name, u.lastname, u.arenausername order by 5 desc,2,1 limit :lt");
        $sql->bindParam(':lt',$limit);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getSumResult($limit = 10000)
    {
        global $conn;
        $sql = $conn->prepare("select uname, ulastname, uusername, sumname , sum(value) value, 0 used_points
from
(
select heroname, uname, ulastname, uusername, case when value >100 then 100 else value end value, sumname
from
(
select h.name heroname, u.name uname, u.lastname ulastname, u.arenausername uusername, u.summonername sumname,  count(*)  value
from userheroresult urh, heroes h, users u
where urh.userid = u.id
and urh.heroid = h.id
group by h.name, u.name, u.lastname, u.arenausername, u.summonername  order by 6 desc,2,1) a) b
group by uname, ulastname, uusername, sumname
order by 5 desc, 1 limit :lt");
        $sql->bindParam(':lt',$limit);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

//    public function getSumResultPagination($offset, $maxNum)
//    {
//        global $conn;
//        $sql = $conn->prepare("select h.name heroname, u.name uname, u.lastname ulastname, u.arenausername uusername, count(*) value
//from userheroresult urh, heroes h, users u
//where urh.userid = u.id
//and urh.heroid = h.id
//group by h.name, u.name, u.lastname, u.arenausername order by 5 desc,2,1 limit $offset, $maxNum ");
//        $sql->execute();
//        $result = $sql->fetchAll(PDO::FETCH_OBJ);
//        return $result;
//    }


    public function insertResult($user, $hero, $date, $time, $worker)
    {
        global $conn;
        $insertNewResult = $conn->prepare("insert into userheroresult (userid, heroid, matchdate, matchtime, workerid) values (:ui, :hi, :dt, :tm, :wr)");
        $insertNewResult->bindParam(':ui', $user);
        $insertNewResult->bindParam(':hi', $hero);
        $insertNewResult->bindParam(':dt', $date);
        $insertNewResult->bindParam(':tm', $time);
        $insertNewResult->bindParam(':wr', $worker);
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