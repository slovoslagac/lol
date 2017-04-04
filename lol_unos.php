<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


if (!$session->isLoggedIn()) {
    redirectTo("login.php");
}

if (isset($_POST["logout"])) {
    echo "Izlogovali smo se <br>";
    $session->logout();
    header("Location:index.php");
}


if (isset($_POST['user']) != ''){
    $tmpusr = new user();
    if (($tmpusr->getUserByUsername($_POST['username'])) == '') {
    try {
        if (isset($_POST['userposition'])) {$positionId = $_POST['userposition'];} else {$positionId = '';}
        $tmpusr->addUser($_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['sumname'], $_POST['userrank'], $positionId , $_POST['phone'],1);
        redirectTo("lol_klub.php");
    } catch (Exception $e) {
        logAction("Neuspelo azuriranje korisnika", "userid = $session->userid --- $e", 'error.txt');
    }
    } else {
        echo "Izabrani username se vec koristi, izaberite neki drugi";
        header("Location:lol_unos.php");
    }
}



$currentpage =  'lol_klub.php';
include $menuLayout;
?>
<div class="account-container register">

    <div class="content clearfix">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <h1>LOL klub - Novi član</h1>

            <div class="login-fields">

                <p>Obavezno popuniti sva polja:</p>

                <div class="field">
                    <label for="firstname">Ime:</label>
                    <input type="text" name="name" min="1" maxlength="50" placeholder="Ime" class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="lastname">Prezime:</label>
                    <input type="text" name="lastname" min="1" maxlength="50" placeholder="Prezime" class="login"
                           required/>
                </div> <!-- /field -->


                <div class="field">
                    <label for="email">eSports Arena Username:</label>
                    <input type="text" name="username" min="1" maxlength="50" placeholder="eSports Arena username"
                           class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="confirm_password">Telefon:</label>
                    <input type="tel" name="phone" min="1" maxlength="50" placeholder="Telefon" class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Summonner name:</label>
                    <input type="text" name="sumname" min="1" maxlength="50" placeholder="Summoner name" class="login"
                           required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Rank:</label>
                    <select name="userrank">
                        <?php $rnk = new rank();
                        $alltmprnk = $rnk->getAllRanks();
                        foreach ($alltmprnk as $item) { ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                </div> <!-- /field -->
                <div class="field">
                    <label for="password">Pozicija:</label>
                    <fieldset>

                        <legend>Pozicija</legend>
                        <?php $pos = new position();
                        $alltmppos = $pos->getAllPositions();
                        foreach ($alltmppos as $item) { ?>
                            <input type="checkbox" name="userposition" value="<?php echo $item->id ?>" <?php echo ($item->name  == 'ADC')? "checked" : "";?>>
                            <small><?php echo $item->name ?></small>
                        <?php } ?>
                    </fieldset>
                </div> <!-- /field -->


            </div> <!-- /login-fields -->

            <div class="login-actions">


                <input name="user" class="button btn btn-primary btn-large" type="submit" value="Registruj člana"></input>

            </div> <!-- .actions -->

        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>


<?php
include $footerMenuLayout;
?>
</body>

</html>
