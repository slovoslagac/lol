<?php

/**
 * Created by PhpStorm.
 * User: petar.prodanovic
 * Date: 14.3.2017.
 * Time: 15.32
 */
class bonus
{
    


    public function getResults()
    {
        global $conn_old;
        $sql = $conn_old->prepare("SELECT users.Username, FLOOR(SUM((statisticsmain.TotalMinutes)/60)) AS this_month FROM statisticsmain JOIN users ON statisticsmain.UserID=users.Id WHERE MONTH(statisticsmain.StartDateTime) = 3 GROUP BY UserID ORDER BY this_month DESC");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    

}