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

if(isset($_POST['userResults']) != '') {
    $i =0;
    while ($i <15){
        $val = $_POST['heroid'][$i];
        $usr = $_POST['userid'];
        $datetime = $_POST['datetime'][$i];
        $date = strstr($datetime,"T", true);
        $time = str_replace('T','',strstr($datetime,"T", false));

        if ($val >0 and $usr >0 and $date != '' and $time != '' ) {
            $res = new result();
            $res->insertResult($usr, $val, $date, $time);
//            echo "$date-$time";
            unset($res);
        }
//        echo "$i - $val ($usr)  - $date : $time<br>";
        $i++;
    }

}

$defDate = new DateTime();
$formatDate = $defDate->format("Y-m-d");
$date = $defDate->format("Y-m-d");
$time = $defDate->format("G:i");
$maxDate = $date."T".$time;
//echo $maxDate2;
//print_r($defDate);


if (isset($_POST['deleteResult']) != '') {
    $id = $_POST['resultId'];
    $delResult = new result();
    $delResult->deleteResult($id);
    header('location:' . $_SERVER['PHP_SELF']);
}

?>
<head>
    <meta charset="UTF-8">
</head>
<body>
<div>
    <h2> Dodaj rezultate</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table>
            <tr>
                <td><input type="submit" name="userResults" value="Sačuvaj" ></td>
                <td>
                    <select name="userid">
                        <?php  $user = new user(); $allUsers = $user->getAllUsers(); foreach ($allUsers as $item){?>
                            <option  value="<?php echo $item->id?>"><?php echo $item->name ?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <?php for ($i = 1; $i < 11; $i++) { ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td>
                        <select name="heroid[]">
                            <option value="0"></option>
                        <?php $hero = new hero(); $allHeros = $hero->getAllHeros(); foreach ($allHeros  as $item) { ?>
                            <option value="<?php echo $item->id?>"><?php echo $item->name ?></option>
                            <?php }?>
                        </select>
                    </td>
                    <td><input type="datetime-local" name="datetime[]" placeholder="Date" value="<?php echo $maxDate ?>" max="<?php echo $maxDate ?>"></td>
<!--                    <td><input type="time" name="time[]" placeholder="Time"></td>-->

                </tr>
            <?php } ?>

        </table>
    </form>
</div>
<hr>

<div>
    <h3>Trenutne pozicije</h3>

    <table>
        <tr>
            <th>Igrač</th>
            <th>Heroj</th>
            <th>Broj pobeda</th>
        </tr>
        <?php $result = new result();
        $allresults = $result->getSumResult();
        foreach ($allresults as $item) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td><?php echo $item->uname ?></td>
                    <td><?php echo $item->heroname ?></td>
                    <td><?php echo $item->value ?></td>
                    <td>
<!--                        <input type="hidden" value="--><?php //echo $item->id ?><!--" name="resultId">-->
<!--                        <input type="submit" name="deleteResult" value="Obriši"></td>-->
                </tr>
            </form>


            <?php
        }

        ?>
    </table>

</div>