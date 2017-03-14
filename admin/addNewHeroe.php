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
include(join(DIRECTORY_SEPARATOR, array(INC_PATH . DS . 'hero.php')));

//sredjivanje pozicija

if (isset($_POST['hero']) != '') {
    $hero = new hero();
    if (empty($hero->getHeroByName($_POST['name'])) and ($_POST['name'] != '')) {
        $hero->addHero($_POST['name']);
        echo $_POST['name'];
        header('location:' . $_SERVER['PHP_SELF']);
    } else {
        if ($_POST['name'] == '') {
            echo "Pozicija mora imati minimalno 1 karakter";
        } else {
            echo "Uneti heroj vec postoji";
        }
    }
}

if (isset($_POST['deleteHero']) != '') {
    $id = $_POST['heroId'];
    $delHero = new hero();
    $delHero->deleteHero($id);
    header('location:' . $_SERVER['PHP_SELF']);
}

?>


<head>
    <meta charset="UTF-8">
</head>
<body>

<hr>
<div>
    <h2>Dodaj novog heroja</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Pozicija: <input type="text" name="name" min="1">
        <input type="submit" name="hero" value="Sačuvaj">
    </form>
</div>

<div>
    <h3>Trenutne pozicije</h3>

    <table>
        <?php $her = new hero();
        $allheroes = $her->getAllHeros();
        foreach ($allheroes as $item) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td><?php echo $item->name ?></td>
                    <td>
                        <input type="hidden" value="<?php echo $item->id ?>" name="heroId">
                        <input type="submit" name="deleteHero" value="Obriši"></td>
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


