<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 14.3.2017
 * Time: 7:56
 */

include(join(DIRECTORY_SEPARATOR, array('..','includes', 'init.php')));

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
        $array = $this->getAllPositions();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }
    }
}


$position = new position();
print_r($position->getPositionById(1));