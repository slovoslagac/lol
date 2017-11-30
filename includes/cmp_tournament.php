<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 29.11.2017
 * Time: 14:35
 */
class cmp_tournament
{
    public function getall(){
        global $conn_cmp;
        $sql=$conn_cmp->prepare("select t.name tournamentname, g.name as gamename, p.name as platformname, date_format(t.tournamenttime, '%d.%c.%Y. %H:%i') as starttime, t.id as tournamentid
from tournaments t, games g, platforms p
where t.tournamentgame = g.id
and t.platform = p.id");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}