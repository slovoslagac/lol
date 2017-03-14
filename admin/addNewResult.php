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
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'result.php')));
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'user.php')));
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'hero.php')));

if(isset($_POST['userResults']) != '') {
    $i =0;
    while ($i <15){
        $val = $_POST['heroid'][$i];
        $usr = $_POST['userid'];
        $date = $_POST['date'][$i];
        $time = $_POST['time'][$i];
        if ($val >0 and $usr >0 and $date != '' and $time != '') {
            $res = new result();
            $res->insertResult($usr, $val, $date, $time);
        }
//        echo "$i - $val ($usr)  - $date : $time<br>";
        $i++;
    }

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
                <td><input type="submit" name="userResults" value="Sačuvaj"></td>
                <td>
                    <select name="userid">
                        <?php  $user = new user(); $allUsers = $user->getAllUsers(); foreach ($allUsers as $item){?>
                            <option  value="<?php echo $item->id?>"><?php echo $item->name ?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <?php for ($i = 1; $i < 16; $i++) { ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td>
                        <select name="heroid[]">
                        <?php $hero = new hero(); $allHeros = $hero->getAllHeros(); foreach ($allHeros  as $item) { ?>
                            <option value="<?php echo $item->id?>"><?php echo $item->name ?></option>
                            <?php }?>
                        </select>
                    </td>
                    <td><input type="date" name="date[]" placeholder="Date"></td>
                    <td><input type="time" name="time[]" placeholder="Time"></td>

                </tr>
            <?php } ?>

        </table>
    </form>
</div>