<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 2.12.2017
 * Time: 20:16
 */
class cmp_results
{
    function getMatchesFifa(){
        global $conn_cmp;
        $sql=$conn_cmp->prepare("select h.name home, v.name visitor, m.id as id
from matches m, players h, players v
where m.homeparticipantid = h.id
and m.visitorparticipantid = v.id
and m.tournamentid = 1
and m.id not in (select matchid from results)
order by m.matchtime, 1,2");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    function getResultsFifa(){
        global $conn_cmp;
        $sql=$conn_cmp->prepare("select h.name home, v.name visitor, r.homeval hres, r.visitorval vres, m.id
from matches m, players h, players v, results r
where m.homeparticipantid = h.id
and m.visitorparticipantid = v.id
and m.tournamentid = 1
and m.id = r.matchid
order by m.matchtime, 1,2");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    function addresultfifa($id, $h, $v){
        global $conn_cmp;
        $sql=$conn_cmp->prepare("insert into results (matchid, homeval, visitorval) values (:mid, :h, :v)");
        $sql->bindParam(':mid', $id);
        $sql->bindParam(':h', $h);
        $sql->bindParam(':v', $v);
        $sql->execute();
    }

}