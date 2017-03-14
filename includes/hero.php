<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 13.3.2017
 * Time: 13:20
 */


class hero
{
    private $name;
//    private $id;

    public function getAllHeros()
    {
        global $conn;
        $sql = $conn->prepare("SELECT name, id FROM heros");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getHeroById($id)
    {
        $array = $this->getAllHeros();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }
    }

    public function getHeroByName($name) {
        $array = $this->getAllHeros();
        foreach ($array as $item) {
            if ($item->name == $name) {
                return $item;
            }
        }
    }

    public function addHero($name){
        global $conn;
        $insertNewPosition = $conn->prepare("insert into heros (name) values (:nm)");
        $insertNewPosition->bindParam(':nm',$name);
        $insertNewPosition->execute();
    }

    public function deleteHero($id) {
        global $conn;
        $deletePosition = $conn->prepare("delete from heros where id = :id");
        $deletePosition->bindParam(':id',$id);
        $deletePosition->execute();
    }


}
