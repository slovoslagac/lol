<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 14.3.2017
 * Time: 13:37
 */
class user
{
    private $name;
    private $lastname;
    private $arenausername;
    private $summonername;
    private $rankid;
    private $userid;
    private $phone;


    public function getAllUsers()
    {
        global $conn;
        $sql = $conn->prepare("SELECT * FROM users order by name");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getUserById($id)
    {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }
    }

    public function getUserByName($name) {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->name == $name) {
                return $item;
            }
        }
    }

    public function getUserByUsername($username) {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->arenausername == $username) {
                return $item;
            }
        }
    }

    public function addUser($name, $lastname, $username, $sumname, $rank, $pos, $phone){
        global $conn;
        $insertNewUser = $conn->prepare("insert into users (name, lastname, arenausername, summonername, rankid, positionid, phone) values (:nm, :ln, :au, :sn, :rn, :po, :ph)");
        $insertNewUser->bindParam(':nm',$name);
        $insertNewUser->bindParam(':ln', $lastname);
        $insertNewUser->bindParam(':au', $username);
        $insertNewUser->bindParam(':sn', $sumname);
        $insertNewUser->bindParam(':rn', $rank);
        $insertNewUser->bindParam(':po', $pos);
        $insertNewUser->bindParam(':ph', $phone);
        $insertNewUser->execute();
    }

    public function deleteUserById($id) {
        global $conn;
        $deletePosition = $conn->prepare("delete from users where id = :id");
        $deletePosition->bindParam(':id',$id);
        $deletePosition->execute();
    }
}