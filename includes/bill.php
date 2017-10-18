<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.4.2017
 * Time: 12:29
 */
class bill
{
    public $id;

    public function getLastBillsByUser($limit = 3, $wrk = '', $type = 1)
    {
        global $conn;
        $sql = $conn->prepare("select * from bills where workerid = :us and type = :tp order by tstamp desc limit :lt");
        $sql->bindParam(":lt", $limit);
        $sql->bindParam(":us", $wrk);
        $sql->bindParam(":tp", $type);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getLastBillsByUserDetails($limit = 3, $wrk = '', $type = 1)
    {
        global $conn;
        $sql = $conn->prepare("select a.billid, a.pricetype, a.amount , a.productid, u.arenausername username, a.type
from
(
select b.id billid, b.pricetype pricetype, br.numProducts amount , br.sellingproductid productid, b.userid, br.type
from
(
select *
from bills
where workerid = :wk
and type = :tp
order by tstamp desc
limit :lt) b,
billsrows br
where br.billrid = b.id ) a
left join users u on u.id = a.userid");
        $sql->bindParam(":lt", $limit);
        $sql->bindParam(":wk", $wrk);
        $sql->bindParam(":tp", $type);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getLastBill($limit = 1, $type = 1)
    {
        global $conn;
        $sql = $conn->prepare("select * from bills where type = :tp order by id desc limit :lt");
        $sql->bindParam(":lt", $limit);
        $sql->bindParam(":tp", $type);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addBill($wrkid, $usrid, $bils, $prty, $type = 1)
    {
        global $conn;
        $sql = $conn->prepare("insert into bills ( workerid, userid, billsum, pricetype, type ) values (:wr, :us, :bs, :pt, :tp)");
        $sql->bindParam(':wr', $wrkid);
        $sql->bindParam(':us', $usrid);
        $sql->bindParam(':bs', $bils);
        $sql->bindParam(':pt', $prty);
        $sql->bindParam(":tp", $type);
        $sql->execute();
    }


    public function deleteBillById($id){
        global $conn;
        $sql = $conn->prepare("delete from bills where id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function updateBillById($id, $userid, $sum, $prtype){
        global  $conn;
        $sql= $conn->prepare("update bills set userid = :us, billsum = :sm, pricetype = :tp where id = :id;");
        $sql->bindParam(":id",$id);
        $sql->bindParam(":sm",$sum);
        $sql->bindParam(":us",$userid);
        $sql->bindParam(":tp",$prtype);
        $sql->execute();
    }
}