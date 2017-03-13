<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:20
 */

require_once ('db.php');

class position
{
    public $name;
    public $id;

    public function getAllPositions()
    {
        global $conn;
        $sql = $conn->prepare("SELECT name, id FROM positions");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getPositionById($id)
    {
        $array = $this->getAllSports();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item->name;
            }
        }
    }
}

$position = new position();
var_dump($position->getAllPositions());