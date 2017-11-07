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
        $sql = $conn->prepare("select a.billid, a.pricetype, a.amount , a.productid, u.arenausername username, a.type, now() - a.tstamp timediff, a.tstamp, a.sptype
from
(
select b.id billid, b.pricetype pricetype, br.numProducts amount , br.sellingproductid productid, b.userid, br.type, b.tstamp, sp.typeid as sptype
from
(
select *
from bills
where workerid = :wk
and type = :tp
order by tstamp desc
limit :lt) b,
billsrows br, sellingproducts sp
where br.billrid = b.id
and br.sellingproductid = sp.id ) a
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


    public function deleteBillById($id)
    {
        global $conn;
        $sql = $conn->prepare("delete from bills where id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function updateBillById($id, $userid, $sum, $prtype)
    {
        global $conn;
        $sql = $conn->prepare("update bills set userid = :us, billsum = :sm, pricetype = :tp where id = :id;");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":sm", $sum);
        $sql->bindParam(":us", $userid);
        $sql->bindParam(":tp", $prtype);
        $sql->execute();
    }

    public function addBillDetails($billid, $safe, $deposit, $computers, $costs, $moneysum, $comment)
    {
        global $conn;
        $sql = $conn->prepare("insert into billsdetails (billrid,safe,deposit,computers, costs,moneysum, comment) VALUES (:id, :sa, :de, :cmp,:co, :mo, :cm)");
        $sql->bindParam(":id", $billid);
        $sql->bindParam(":sa", $safe);
        $sql->bindParam(":de", $deposit);
        $sql->bindParam(":cmp", $computers);
        $sql->bindParam(":co", $costs);
        $sql->bindParam(":mo", $moneysum);
        $sql->bindParam(":cm", $comment);
        $sql->execute();

    }

     public function addBillSum($billid, $safe, $deposit, $computers, $costs, $moneysum, $wage )
     {
         global $conn;
         $sql = $conn->prepare("insert into billssum (billrid, value, type) values ($billid, :sa, 1), ($billid, :de, 2),($billid, :cmp, 3),($billid, :co, 4),($billid, :mo, 5),($billid, :wg, 6)");
         $sql->bindParam(":sa", $safe);
         $sql->bindParam(":de", $deposit);
         $sql->bindParam(":cmp", $computers);
         $sql->bindParam(":co", $costs);
         $sql->bindParam(":mo", $moneysum);
         $sql->bindParam(":wg", $wage);
         $sql->execute();
     }

}