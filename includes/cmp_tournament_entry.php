<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.11.2017
 * Time: 13:10
 */
class cmp_tournament_entry
{
    private $playerid = null;
    private $teamid = null;
    private $tournamentid = null;
    private $status = 0;

    public function setattribute($attr, $val){
        $this->$attr = $val;
    }

    public function addtournamententry(){
        global $conn_cmp;
        $sql = $conn_cmp->prepare("insert into tournament_entry(playerid, teamid, tournamentid, status) values (:pid, :tid, :trnm, :st)");
        $sql->bindParam(":pid", $this->playerid);
        $sql->bindParam(":tid", $this->teamid);
        $sql->bindParam(":trnm", $this->tournamentid);
        $sql->bindParam(":st", $this->status);
        $sql->execute();

    }
}