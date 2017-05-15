<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 28.3.2017
 * Time: 10:49
 */
class info
{
    public function getAllInformations($offset =0,$limit = 100000)
    {
        global $conn;
        $sql = $conn->prepare("select DATE_FORMAT(date, '%e') tmpdate, DATE_FORMAT(date, '%b') as month, tittle, text, date, id
from informations i order by date desc, timestamp desc limit  $offset,$limit" );
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addNewInformation($date, $tittle, $text, $worker){
        global $conn;
        $info = $conn->prepare("insert into informations(date,tittle, text,workerid) values (:dt, :ti, :tx, :wr)");
        $info->bindParam(':dt',$date);
        $info->bindParam(':ti',$tittle);
        $info->bindParam(':tx',$text);
        $info->bindParam(':wr',$worker);
        $info->execute();
    }

    public function getInformationById($val){
        global $conn;
        $currentInfo = $conn->prepare("select * from informations where id = :nm");
        $currentInfo->bindParam(':nm', $val);
        $currentInfo->execute();
        $result = $currentInfo->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function deleteInformatioById($val) {
        global $conn;
        $deleteInfo = $conn->prepare("delete from informations where id = :id");
        $deleteInfo->bindParam(':id', $val);
        $deleteInfo->execute();
    }

    public function editInfo($id, $date, $text, $tittle){
        global $conn;
        $updateInfo = $conn->prepare("update informations set tittle = :tt, text = :tx, date = :dt where id = :id");
        $updateInfo->bindParam(":tt",$tittle);
        $updateInfo->bindParam(":tx",$text);
        $updateInfo->bindParam(":dt",$date);
        $updateInfo->bindParam(":id",$id);
        $updateInfo->execute();

    }
}



