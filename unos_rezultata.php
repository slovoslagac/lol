<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


if (isset($_POST['userResults']) != '') {

        $i = 0;
        while ($i < 10) {
            $val = $_POST['heroid'][$i];
            $usr = $_POST['userid'];
            $datetime = $_POST['datetime'][$i];
            $date = strstr($datetime, "T", true);
            $time = str_replace('T', '', strstr($datetime, "T", false));
            if ($val > 0 and $usr > 0 and $date != '' and $time != '') {
                try {
                $res = new result();
                $res->insertResult($usr, $val, $date, $time, $session->userid);
                logAction("Unos Rezultata", "userid = $session->userid --- $usr, $val, $date, $time,", 'resultLog.txt');
                unset($res);
                }

                catch(Exception $e){
                    logAction("Unos Rezultata - error", "userid = $session->userid --- $e", 'error.txt');
                }
            }
            $i++;
        }
        redirectTo("index.php");

}

$defDate = new DateTime();
$formatDate = $defDate->format("Y-m-d");
$date = $defDate->format("Y-m-d");
$time = $defDate->format("H:i");
$maxDate = $date . "T" . $time;


if (isset($_POST['deleteResult']) != '') {
    $id = $_POST['resultId'];
    $delResult = new result();
    $delResult->deleteResult($id);
    header('location:' . $_SERVER['PHP_SELF']);
}



//$currentpage =  basename($_SERVER["SCRIPT_FILENAME"]);
$currentpage = 'lol_takmicenje.php';
include $menuLayout;
?>
<div class="result-container register">

    <div class="content clearfix">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <h1>Unos rezultata</h1>

            <div class="login-fields">

                <p>Izaberi igrača za kojeg unosiš rezutate:</p>

                <div class="field">
                    <label for="password">Rank:</label>
                    <select name="userid">
                        <?php $user = new user();
                        $allUsers = $user->getAllUsers();
                        foreach ($allUsers as $item) { ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->arenausername ?></option>
                        <?php } ?>
                    </select>
                </div> <!-- /field -->

                <p>Popuniti samo onoliko partija koliko je igrač prijavio</p>
                <?php for ($i = 1; $i < 11; $i++) { ?>
                    <div class="field">
                        <div class="champion">
                            <div class="rbr"><?php echo $i ?></div>
                            <label for="password">Rank:</label>
                            <select name="heroid[]">
                                <option value="0"></option>
                                <?php $hero = new hero();
                                $allHeros = $hero->getAllHeros();
                                foreach ($allHeros as $item) { ?>
                                    <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                <?php } ?>
                            </select>
                            <input type="datetime-local" name="datetime[]" placeholder="Date"
                                   value="<?php echo $maxDate ?>" max="<?php echo $maxDate ?>">
                        </div> <!-- /field -->
                    </div> <!-- /field -->
                <?php } ?>


            </div> <!-- /login-fields -->

            <div class="login-actions">
				
                <span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" required/>
					<label class="choice" for="Field">Potvrđujem da sam proverio/la sve prijavljene partije na sajtu www.lolskill.net i da su sve ispravne.</label>
				</span>

                <button class="button btn btn-primary btn-large" name="userResults" type="submit">Unesi rezultate</button>

            </div> <!-- .actions -->

        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->

<?php
include $footerMenuLayout;
?>

</body>

</html>
