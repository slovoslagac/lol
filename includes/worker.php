<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.3.2017
 * Time: 14:22
 */
class worker
{
    public function addWorker($name, $lastname, $username, $password)
    {
        global $conn;
        $insertNewWorker = $conn->prepare("insert into workers (name,lastname, username, password ) values (:nm, :ln, :un, :ps)");
        $insertNewWorker->bindParam(':nm', $name);
        $insertNewWorker->bindParam(':ln', $lastname);
        $insertNewWorker->bindParam(':un', $username);
        $insertNewWorker->bindParam(':ps', $password);
        $insertNewWorker->execute();
    }

    public function getAllWorkers()
    {
        {
            global $conn;
            $sql = $conn->prepare("SELECT * FROM workers");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
    }

    public function getWorkerByUsername($usr)
    {
        $array = $this->getAllWorkers();
        foreach ($array as $item) {
            if (strtolower($item->username) == strtolower($usr)) {
                return $item;
            }
        }

    }

    public function getWorkerById($id)
    {
        $array = $this->getAllWorkers();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }

    }

    public function deleteWorker($id) {
        global $conn;
        $deleteWorker = $conn->prepare("delete from workers where id = :id");
        $deleteWorker->bindParam(':id',$id);
        $deleteWorker->execute();
    }

    public function getAdmin(){
        global $conn;
        $sql = $conn->prepare("select id from workertype where upper(name) = 'ADMIN'");
        $sql->execute();
//        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;


    }
}