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


    public function getAllUsersLol()
    {
        global $conn;
        $sql = $conn->prepare("SELECT u.name, u.lastname,arenausername, summonername, phone, discount, p.name positionname, r.name rankname, u.id, u.creditstatus, SLuserId
FROM users u
left join positions p on u.positionid = p.id
left join ranks r on u.rankid = r.id
where u.lolKlub = 1
order by 3,1,2");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }


    public function getAllUsers()
    {
        global $conn;
        $sql = $conn->prepare("SELECT u.name, u.lastname,arenausername, summonername, phone, discount, p.name positionname, r.name rankname, u.id as id, u.creditstatus, SLuserId
FROM users u
left join positions p on u.positionid = p.id
left join ranks r on u.rankid = r.id
order by 3,1,2");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getAllUsersByRank($limit= 20)
    {
        global $conn;
        $sql = $conn->prepare("SELECT u.name, u.lastname,arenausername, summonername, phone, discount, p.name positionname, r.name rankname, r.order, u.id, u.creditstatus, SLuserId
FROM users u
left join positions p on u.positionid = p.id
left join ranks r on u.rankid = r.id
where u.lolKlub = 1
order by r.order,3 limit :lt");
        $sql->bindParam(':lt',$limit);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }



    public function transferUsers($usr, $id)
    {
        global $conn;
        $sql = $conn->prepare("Insert into users (arenausername, SLuserId) values (:usr, :id) ");
        $sql->bindParam(':usr', $usr);
        $sql->bindParam(':id', $id);
        $sql->execute();
        unset($conn);
    }


    public function transferWorkers($usr,$credits = 1, $type = 2)
    {
        global $conn;
        $sql = $conn->prepare("Insert into users (arenausername, creditstatus, usertype) values (:usr, :cs, :tp) ");
        $sql->bindParam(':usr', $usr);
        $sql->bindParam(':cs', $credits);
        $sql->bindParam(':tp', $type);
        $sql->execute();
        unset($conn);
    }

    public function getUserById($id)
    {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->id == (int)$id) {
                return $item;
            }
        }
    }

    public function getUserBySlId($id)
    {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->SLuserId == (int)$id) {
                return $item;
            }
        }
    }

    public function getUserByName($name)
    {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if (strtolower($item->name) == $name) {
                return $item;
            }
        }
    }

    public function getUserByUsername($username)
    {
        $array = $this->getAllUsers();
        foreach ($array as $item) {
            if ($item->arenausername == $username) {
                return $item;
            }
        }
    }



    public function addUser($name, $lastname, $username, $sumname, $rank, $pos, $phone, $lol, $slid)
    {
        global $conn;
        $insertNewUser = $conn->prepare("insert into users (name, lastname, arenausername, summonername, rankid, positionid, phone, lolKlub, SLuserId) values (:nm, :ln, :au, :sn, :rn, :po, :ph, :lk, :sl) ");
        $insertNewUser->bindParam(':nm', $name);
        $insertNewUser->bindParam(':ln', $lastname);
        $insertNewUser->bindParam(':au', $username);
        $insertNewUser->bindParam(':sn', $sumname);
        $insertNewUser->bindParam(':rn', $rank);
        $insertNewUser->bindParam(':po', $pos);
        $insertNewUser->bindParam(':ph', $phone);
        $insertNewUser->bindParam(':lk', $lol);
        $insertNewUser->bindParam(':sl', $slid);
        $insertNewUser->execute();
    }

    public function updateUser($id, $name, $lastname, $username, $sumname, $rank, $pos, $phone, $lol)
    {
        global $conn;
        $updateUser = $conn->prepare("update users set name = :nm, lastname = :ln, arenausername=:au , summonername=:sn, rankid = :rn, positionid = :po, phone =:ph, lolKlub = :lk where id= :id");
        $updateUser->bindParam(':nm', $name);
        $updateUser->bindParam(':ln', $lastname);
        $updateUser->bindParam(':au', $username);
        $updateUser->bindParam(':sn', $sumname);
        $updateUser->bindParam(':rn', $rank);
        $updateUser->bindParam(':po', $pos);
        $updateUser->bindParam(':ph', $phone);
        $updateUser->bindParam(':id', $id);
        $updateUser->bindParam(':lk', $lol);
        $updateUser->execute();
    }

    public function resetCreditStatus($val = 0, $ar = '') {
        global $conn;

        if($ar == '') {
            $sql = $conn->prepare("Update users set creditstatus = :vl where usertype = 1");
        } else {
            $sql = $conn->prepare("Update users set creditstatus = :vl and SluserId in ($ar) and usertype = 1");
        }
        $sql->bindParam(':vl', $val);


        $sql->execute();
        var_dump($sql);
    }



    public function deleteUserById($id)
    {
        global $conn;
        $deletePosition = $conn->prepare("delete from users where id = :id");
        $deletePosition->bindParam(':id', $id);
        $deletePosition->execute();
    }


}