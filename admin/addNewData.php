<!DOCTYPE html>
<html>
<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 14.3.2017
 * Time: 9:16
 */

include(join(DIRECTORY_SEPARATOR, array('..', 'includes', 'init.php')));
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'position.php')));
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'rank.php')));
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'user.php')));

//sredjivanje pozicija

if (isset($_POST['position']) != '') {
    $position = new position();
    if (($position->getPositionByName($_POST['name']) == '') and ($_POST['name'] != '')) {
        $position->addPosition($_POST['name']);
        echo $_POST['name'];
        header('location:' . $_SERVER['PHP_SELF']);
    } else {
        if ($_POST['name'] == '') {
            echo "Pozicija mora imati minimalno 1 karakter";
        } else {
            echo "Uneta pozicija vec postoji";
        }
    }
}

if (isset($_POST['deletePosition']) != '') {
    $id = $_POST['positionId'];
    $delPosition = new position();
    $delPosition->deletePosition($id);
    header('location:' . $_SERVER['PHP_SELF']);
}


// sredjivanje rankova

if (isset($_POST['rank']) != '') {
    $rank = new rank();
    if (($rank->getRankByName($_POST['name']) == '') and ($_POST['name'] != '')) {
        $rank->addRank($_POST['name']);
        echo $_POST['name'];
        header('location:' . $_SERVER['PHP_SELF']);
        unset($rank);
    } else {
        if ($_POST['name'] == '') {
            echo "Rank mora imati minimalno 1 karakter";
        } else {
            echo "Uneti rank vec postoji";
        }
    }
}

if (isset($_POST['deleteRank']) != '') {
    $id = $_POST['rankId'];
    $delRank = new rank();
    $delRank->deleteRank($id);
    unset($delRank);
    header('location:' . $_SERVER['PHP_SELF']);
}


if (isset($_POST['deleteUser']) != '') {
    $id = $_POST['userId'];
    $delUser = new user();
    $delUser->deleteUserById($id);
    header('location:' . $_SERVER['PHP_SELF']);
}




//sredjivanje usera

if (isset($_POST['user']) != ''){
    $tmpusr = new user();
    if (($tmpusr->getUserByUsername($_POST['username'])) == '') {

        $tmpusr->addUser($_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['sumname'], $_POST['userrank'], $_POST['userposition'], $_POST['phone']);
    } else {
        echo "Izabrani username se vec koristi, izaberite neki drugi";
    }
}
?>
<head>
    <meta charset="UTF-8">
</head>
<body>
<div>
    <h2>Dodaj novog igraca</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table>
            <tr>
                <td><input type="text" name="name" min="1" maxlength="50" placeholder="Name"></td>
                <td><input type="text" name="lastname" min="1" maxlength="50" placeholder="Lastname"></td>
                <td>*<input type="text" name="username" min="1" maxlength="50" placeholder="eSports Arena username" required></td>
                <td><input type="text" name="sumname" min="1" maxlength="50" placeholder="Summoner Name"></td>
                <td>
                    <select name="userrank">
                        <?php $rnk = new rank();
                        $alltmprnk = $rnk->getAllRanks();
                        foreach ($alltmprnk as $item) { ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <?php $pos = new position();
                    $alltmppos = $pos->getAllPositions();
                    foreach ($alltmppos as $item) { ?>
                        <input type="checkbox" name="userposition" value="<?php echo $item->id ?>"><?php echo $item->name ?>
                    <?php } ?>

                </td>

                <td><input type="tel" name="phone" min="1" maxlength="50" placeholder="Broj telefona"></td>
            </tr>
            <input type="submit" name="user" value="Sačuvaj">
        </table>
    </form>
</div>

<div>
    <h3>Trenutni korisnici</h3>

    <table>
        <?php $usr = new user();
        $allusers = $usr->getAllUsersLol();
        foreach ($allusers as $item) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td><?php echo $item->id ?></td>
                    <td><?php echo $item->name ?></td>
                    <td><?php echo $item->lastname ?></td>
                    <td><?php echo $item->arenausername ?></td>
                    <td><?php echo $item->rankid ?></td>
                    <td><?php echo $item->positionid ?></td>
                    <td><?php echo $item->phone?></td>
                    <td>
                        <input type="hidden" value="<?php echo $item->id ?>" name="userId">
                        <input type="submit" name="deleteUser" value="Obriši"></td>
                </tr>
            </form>


            <?php
        }

        ?>
    </table>

</div>
<hr>
<div>
    <h2>Dodaj novu poziciju</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Pozicija: <input type="text" name="name" min="1">
        <input type="submit" name="position" value="Sačuvaj">
    </form>
</div>

<div>
    <h3>Trenutne pozicije</h3>

    <table>
        <?php $pos = new position();
        $allpos = $pos->getAllPositions();
        foreach ($allpos as $item) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td><?php echo $item->name ?></td>
                    <td>
                        <input type="hidden" value="<?php echo $item->id ?>" name="positionId">
                        <input type="submit" name="deletePosition" value="Obriši"></td>
                </tr>
            </form>


            <?php
        }

        ?>
    </table>

</div>
<hr>
<div>
    <h2>Dodaj novi rank</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Rank: <input type="text" name="name" min="1">
        <input type="submit" name="rank" value="Sačuvaj">

    </form>
</div>

<div>
    <h3>Trenutni rankovi</h3>

    <table>
        <?php $rnk = new rank();
        $allrnk = $rnk->getAllRanks();
        foreach ($allrnk as $item) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td><?php echo $item->name ?></td>
                    <td>
                        <input type="hidden" value="<?php echo $item->id ?>" name="rankId">
                        <input type="submit" name="deleteRank" value="Obriši"></td>
                </tr>
            </form>


            <?php
        }

        ?>
    </table>

</div>


<hr>
</body>


</html>


