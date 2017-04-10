<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 4.4.2017
 * Time: 08:50
 */
class SLUsers
{
    public function getAllUsers()
    {
        global $conn_old;
        $sql = $conn_old->prepare("select distinct Username, id from users where  accountStatus = 1 order by id");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getUserByName($name)
    {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->Username == $name) {
                return $item;
            }
        }

    }


}


