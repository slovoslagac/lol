<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 15.3.2017
 * Time: 14:22
 */
class worker
{
    public function addWorker($name, $lastname, $email, $password, $type)
    {
        global $conn;
        $insertNewWorker = $conn->prepare("insert into workers (name,lastname, email, password, workertypeid ) values (:nm, :ln, :em, :ps, :tp)");
        $insertNewWorker->bindParam(':nm', $name);
        $insertNewWorker->bindParam(':ln', $lastname);
        $insertNewWorker->bindParam(':em', $email);
        $insertNewWorker->bindParam(':ps', $password);
        $insertNewWorker->bindParam(':tp', $type);
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

    public function getWorkerByEmail($val)
    {
        $array = $this->getAllWorkers();
        foreach ($array as $item) {
            if (strtolower($item->email) == strtolower($val)) {
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
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getOperator(){
        global $conn;
        $sql = $conn->prepare("select id from workertype where upper(name) = 'OPERATER'");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function updateWorkerPass($id, $pass)
    {
        global $conn;
        $updateUser = $conn->prepare("update workers set password = :pass where id= :id");
        $updateUser->bindParam(':pass', $pass);
        $updateUser->bindParam(':id', $id);
        $updateUser->execute();
    }
}