<?php

/**
 * Created by PhpStorm.
 * User: petar.prodanovic
 * Date: 14.3.2017.
 * Time: 15.32
 */
class bonus
{

    public function getResults($month)
    {
        global $conn_old;
        $sql = $conn_old->prepare("SELECT users.Username, FLOOR(SUM((statisticsmain.TotalMinutes)/60)) AS this_month, statisticsmain.UserID as id
FROM statisticsmain JOIN users ON statisticsmain.UserID=users.Id WHERE MONTH(statisticsmain.StartDateTime) = :mt GROUP BY statisticsmain.UserID ORDER BY this_month DESC");
        $sql->bindParam(':mt', $month);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }


    public function addMonthlyValues($num, $id, $month){
        global $conn;
        $sql = $conn->prepare("insert into bonushours (numHours, SLuserId, monthNum) values(:nh, :us, :mn)");
        $sql->bindParam(':nh', $num);
        $sql->bindParam(':us', $id);
        $sql->bindParam(':mn', $month);
        $sql->execute();
    }

    public function deleteMonthlyValues($month){
        global $conn;
        $sql = $conn->prepare("delete from bonushours where monthNum = :mt");
        $sql->bindParam(':mt',$month);
        $sql->execute();
    }






    public function getMonthlyBonus($month){
        global $conn;
        $sql = $conn->prepare("select * from bonushours where monthNum = :mt");
        $sql->bindParam(':mt',$month);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        $resultArray=array();
        foreach($result as $item){
            $resultArray[$item->SLuserId] = $item->numHours;
        }

        return $resultArray;
    }
    

}