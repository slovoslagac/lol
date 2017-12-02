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

    function getmatch($id, $tounamentid){
        global $conn_cmp;
        $sql= $conn_cmp->prepare("select * from matches where matchid = :id and tournamentid = :tdi");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":tdi", $tounamentid);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }



    



}