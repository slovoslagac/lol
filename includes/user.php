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
        $sql = $conn->prepare("SELECT u.name, u.lastname,arenausername, summonername, phone, discount, p.name positionname, r.name rankname, u.id, u.creditstatus
FROM users u
left join positions p on u.positionid = p.id
left join ranks r on u.rankid = r.id
order by 3,1,2");
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
            if (strtolower($this->name) == $name) {
                return $item;
            }
        }
    }

    public function getUserByUsername($username) {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if (strtolower($this->arenausername) == $username) {
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

    public function updateUser($id, $name, $lastname, $username, $sumname, $rank, $pos, $phone, $creditstatus) {
        global $conn;
        $updateUser = $conn->prepare("update users set name = :nm, lastname = :ln, arenausername=:au , summonername=:sn, rankid = :rn, positionid = :po, phone =:ph, creditstatus = :cs where id= :id");
        $updateUser->bindParam(':nm', $name);
        $updateUser->bindParam(':ln', $lastname);
        $updateUser->bindParam(':au', $username);
        $updateUser->bindParam(':sn', $sumname);
        $updateUser->bindParam(':rn', $rank);
        $updateUser->bindParam(':po', $pos);
        $updateUser->bindParam(':ph', $phone);
        $updateUser->bindParam(':id', $id);
        $updateUser->bindParam(':cs', $creditstatus);
        $updateUser->execute();
    }

    public function deleteUserById($id) {
        global $conn;
        $deletePosition = $conn->prepare("delete from users where id = :id");
        $deletePosition->bindParam(':id',$id);
        $deletePosition->execute();
    }



}