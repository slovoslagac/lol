<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 2.12.2017
 * Time: 17:27
 */
class cmp_matches
{
    public $tournamentid;
    public $matchtime;
    public $matchid;
    public $homematchid;
    public $homematchidtype;
    public $homeparticipantid;
    public $visitormatchid;
    public $visitormatchidtype;
    public $visitorparticipantid;
    public $roundid;

    function addattribute($atr, $value)
    {
        $this->$atr = $value;
    }

    function addmatch()
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare("insert into matches (tournamentid  ,matchtime  ,matchid  ,homematchid  ,homematchidtype  ,homeparticipantid  ,visitormatchid  ,visitormatchidtype  ,visitorparticipantid  ,roundid)
 VALUES (  :tour, :mtime, :mid, :hmid, :hmidt, :hparid, :vmid, :vmidt, :vparid, :round)");
        $sql->bindParam(':tour', $this->tournamentid);
        $sql->bindParam(':mtime', $this->matchtime);
        $sql->bindParam(':mid', $this->matchid);
        $sql->bindParam(':hmid', $this->homematchid);
        $sql->bindParam(':hmidt', $this->homematchidtype);
        $sql->bindParam(':hparid', $this->homeparticipantid);
        $sql->bindParam(':vmid', $this->visitormatchid);
        $sql->bindParam(':vmidt', $this->visitormatchidtype);
        $sql->bindParam(':vparid', $this->visitorparticipantid);
        $sql->bindParam(':round', $this->roundid);
        $sql->execute();
    }

    function getmatch($id, $tounamentid)
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare("select * from matches where id = :id and tournamentid = :tdi");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":tdi", $tounamentid);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    function getallmatchesplayer()
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare("select h.name home, v.name visitor,  date_format(m.matchtime,'%H:%i')  as matchtime, m.position  as ps, m.id, r.homeval, r.visitorval
from matches m
left join players h on m.homeparticipantid = h.id
left join results r on m.id = r.matchid
left join players v on m.visitorparticipantid = v.id
where m.tournamentid = 1
order by id
;");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }


    function getallmatchesteams()
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare("select h.name home, v.name visitor,  date_format(m.matchtime,'%H:%i')  as matchtime, m.position  as ps, m.id, r.homeval, r.visitorval
from matches m
left join team h on m.homeparticipantid = h.id
left join results r on m.id = r.matchid
left join team v on m.visitorparticipantid = v.id
where m.tournamentid = 2
order by m.matchid
;");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    function gethomematchupdate($matchid, $tournamentid)
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare('select * from matches where homematchid = :mid and tournamentid = :tid limit 1;');
        $sql->bindParam(":mid", $matchid);
        $sql->bindParam(":tid", $tournamentid);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function getvisitormatchupdate($matchid, $tournamentid)
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare('select * from matches where visitormatchid = :mid and tournamentid = :tid limit 1;');
        $sql->bindParam(":mid", $matchid);
        $sql->bindParam(":tid", $tournamentid);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function updatehomematch($matchid, $torunamentid, $teamid)
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare('update matches set homeparticipantid = :pid where matchid = :mid and tournamentid = :tid');
        $sql->bindParam(':pid', $teamid);
        $sql->bindParam(':mid', $matchid);
        $sql->bindParam(':tid', $torunamentid);
        $sql->execute();

    }

    function updatevisitormatch($matchid, $torunamentid, $teamid)
    {
        global $conn_cmp;
        $sql = $conn_cmp->prepare('update matches set visitorparticipantid = :pid where matchid = :mid and tournamentid = :tid');
        $sql->bindParam(':pid', $teamid);
        $sql->bindParam(':mid', $matchid);
        $sql->bindParam(':tid', $torunamentid);
        $sql->execute();

    }

}