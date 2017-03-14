<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:20
 */


class rank
{
    private $name;
//    private $id;

    public function getAllRanks()
    {
        global $conn;
        $sql = $conn->prepare("SELECT name, id FROM ranks order by name");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getRankById($id)
    {
        $array = $this->getAllRanks();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }
    }

    public function getRankByName($name) {
        $array = $this->getAllRanks();
        foreach ($array as $item) {
            if ($item->name == $name) {
                return $item;
            }
        }
    }

    public function addRank($name){
        global $conn;
        $insertNewPosition = $conn->prepare("insert into ranks (name) values (:nm)");
        $insertNewPosition->bindParam(':nm',$name);
        $insertNewPosition->execute();
    }

    public function deleteRank($id) {
        global $conn;
        $deletePosition = $conn->prepare("delete from ranks where id = :id");
        $deletePosition->bindParam(':id',$id);
        $deletePosition->execute();
    }


}
