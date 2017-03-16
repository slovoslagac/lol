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


//sredjivanje pozicija

if (isset($_POST['worker']) != '') {
    $worker = new worker();
    if (!($worker->getWorkerByUsername($_POST['username'])) and ($_POST['username'] != '')) {
        $worker->addWorker($_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['password']);
        header('location:' . $_SERVER['PHP_SELF']);
    } else {
        if ($_POST['username'] == '') {
            echo "Korisničko ime mora imati minimalno 1 karakter";
        } else {
            echo "Uneti radnik vec postoji";
        }
    }
}

if (isset($_POST['deleteWorker']) != '') {
    $id = $_POST['workerId'];
    $delWorker = new worker();
    $delWorker->deleteWorker($id);
    header('location:' . $_SERVER['PHP_SELF']);
}

?>


<head>
    <meta charset="UTF-8">
</head>
<body>

<hr>
<div>
    <h2>Dodaj novog Radnika</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Ime: <input type="text" name="name" min="1" required>
        Prezime: <input type="text" name="lastname" min="1" required>
        Username: <input type="text" name="username" min="1" required>
        Šifra:<input type="password" min="1" name="password" required>
        <input type="submit" name="worker" value="Sačuvaj">
    </form>
</div>

<div>
    <h3>Trenutni radnici</h3>

    <table>
        <?php $wrk = new worker();
        $allworkers = $wrk->getAllWorkers();
        foreach ($allworkers as $item) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td><?php echo $item->name ?></td>
                    <td><?php echo "($item->username)" ?></td>

                    <td>
                        <input type="hidden" value="<?php echo $item->id ?>" name="workerId">
                        <input type="submit" name="deleteWorker" value="Obriši"></td>
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


