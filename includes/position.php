<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:20
 */


class position
{
    private $name;
//    private $id;

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
        $array = $this->getAllPositions();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }
    }

    public function getPositionByName($name) {
        $array = $this->getAllPositions();
        foreach ($array as $item) {
            if ($item->name == $name) {
                return $item;
            }
        }
    }

    public function addPosition($name){
        global $conn;
        $insertNewPosition = $conn->prepare("insert into positions (name) values (:nm)");
        $insertNewPosition->bindParam(':nm',$name);
        $insertNewPosition->execute();
    }

    public function deletePosition($id) {
        global $conn;
        $deletePosition = $conn->prepare("delete from positions where id = :id");
        $deletePosition->bindParam(':id',$id);
        $deletePosition->execute();
    }


}
