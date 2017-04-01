<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
if (isset($_POST['edit'])) {
    echo 'alooo';
}

$rnk = new rank();
$alltmprnk = $rnk->getAllRanks();

$pos = new position();
$alltmppos = $pos->getAllPositions();

$usr = new user();
$allusers = $usr->getAllUsers();


$lok = basename($_SERVER["SCRIPT_FILENAME"]);

if (isset($_POST["editUser"])) {
    $userid = $_POST['user'];
    $oldAttr = $usr->getUserById($userid);
    $firtsname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $sumname = $_POST['sumname'];
    $rankname = $_POST['userrank'];
    $rank = $rnk->getRankByName($rankname);
    if (isset($_POST['userposition'])) {
        $positionName = $_POST['userposition'];
    } else {
        $positionName = $oldAttr->positionname;
    }
    $position = $pos->getPositionByName($positionName);

    if (isset($_POST['credit'])) {
        $creditId = $_POST['credit'];
    } else {
        $creditId = $oldAttr->creditstatus;
    }
//    echo "$rank->id $firtsname, $lastname, $sumname,$position->id, $phone, $creditId, $userid";
    try {
        $usr->updateUser($userid, $firtsname, $lastname, $username, $sumname, $rank->id, $position->id, $phone, $creditId);
        header("Location:$lok");
    } catch (Exception $e) {
        logAction("Neuspelo azuriranje korisnika", "userid = $session->userid --- $e", 'error.txt');
    }
}

if (isset($_POST['deleteUser'])) {
    $userid = $_POST['userIdForDelete'];
    try {
        $usr->deleteUserById($userid);
        unset($usr);
        header("Location:$lok");
    } catch (Exception $e) {
        logAction("Neuspelo brisanje korisnika", "userid = $session->userid --- $e", 'error.txt');
    }
}


include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">

                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-user"></i>
                            <h3>LOL klub - članovi</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="lol_unos.php" role="button" class="btn">Dodaj novog člana</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th> RB</th>
                                    <th> Ime</th>
                                    <th> Prezime</th>
                                    <th> Arena Username</th>
                                    <th> Summoner Name</th>
                                    <th> Rank</th>
                                    <th> Popust</th>
                                    <th> Pozicija</th>
                                    <th> Telefon</th>
                                    <th class="td-actions"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach ($allusers as $item) {
                                    $jsonItem = json_encode($item); ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td id="name<?php echo $i ?>"><?php echo $item->name ?></td>
                                        <td id="lastname<?php echo $i ?>"><?php echo $item->lastname ?></td>
                                        <td id="arenausername<?php echo $i ?>"><?php echo $item->arenausername ?></td>
                                        <td id="summonername<?php echo $i ?>"><?php echo $item->summonername ?></td>
                                        <td id="rankname<?php echo $i ?>"><?php echo $item->rankname ?></td>
                                        <td id="discount<?php echo $i ?>"><?php echo ($item->discount == null) ? "0%" : "$item->discount%"; ?>
                                        <td id="positionname<?php echo $i ?>"><?php echo $item->positionname ?></td>
                                        <td id="phone<?php echo $i ?>"><?php echo $item->phone ?></td>
                                        <input type="hidden" value="<?php echo $item->id ?>" name="userId" id="userId<?php echo $i ?>">
                                        <!--                                        <input type="hidden" name="deleteUser" value="Obriši">-->
                                        <td class="td-actions">
                                            <a href="#edit" class="btn btn-small btn-success" data-toggle="modal" name="edit" onclick="edit(<?php echo $i ?>)"><i class="btn-icon-only icon-ok"> </i></a>
                                            <a href="#delete" class="btn btn-danger btn-small" data-toggle="modal" name="delete" onclick="deleteUser(<?php echo $i ?>)"><i class="btn-icon-only icon-remove"> </i></a>
                                        </td>
                                    </tr>
                                    </form>


                                    <?php $i++;
                                } ?>


                                </tbody>
                            </table>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->

                </div>
                <!-- /span6 -->
                <!-- Modal -->
                <div id="edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" name="cancel">×</button>
                        <h3 id="myModalLabel">Administracija korisnika</h3>
                    </div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="modal-body">
                            <p>Obavezno popuniti sva polja:</p>
                            <input type="hidden" value="" id="user" name="user">
                            <div class="field">
                                <label for="firstname">Ime:</label>
                                <input type="text" id="firstname" name="firstname" min="1" maxlength="50" class="login" required/>
                            </div> <!-- /field -->

                            <div class="field">
                                <label for="lastname">Prezime:</label>
                                <input type="text" id="lastname" name="lastname" min="1" maxlength="50" class="login"
                                       required/>
                            </div> <!-- /field -->

                            <div class="field">
                                <label for="email">eSports Arena Username:</label>
                                <input type="text" id="username" name="username" min="1" maxlength="50" class="login" required/>
                            </div> <!-- /field -->

                            <div class="field">
                                <label for="confirm_password">Telefon:</label>
                                <input type="tel" id="phone" name="phone" min="1" maxlength="50" class="login" required/>
                            </div> <!-- /field -->

                            <div class="field">
                                <label for="password">Summonner name:</label>
                                <input type="text" name="sumname" id="sumname" min="1" maxlength="50" class="login"
                                       required/>
                            </div> <!-- /field -->

                            <div class="field">
                                <label for="password">Rank:</label>
                                <select name="userrank" id="userrank" required>
                                    <?php
                                    foreach ($alltmprnk as $item) { ?>
                                        <option value="<?php echo $item->name ?>"><?php echo $item->name ?></option>
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
                                        <input type="checkbox" name="userposition" id="userposition" value="<?php echo $item->name ?>">
                                        <small><?php echo $item->name ?></small>
                                    <?php } ?>
                                </fieldset>
                            </div> <!-- /field -->
                            <div class="field">
                                <label for="password">Pozicija:</label>
                                <fieldset>

                                    <legend>Zadužiаvanje</legend>
                                    <input type="checkbox" name="credit" id="credit" value="1">
                                    <small>Da</small>
                                    <input type="checkbox" name="credit" id="credit" value="0">
                                    <small>Ne</small>

                                </fieldset>
                            </div> <!-- /field -->
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"> Poništi</button>
                            <button class="btn btn-primary" id="confirmation" type="submit" name="editUser">Sačuvaj promene</button>
                        </div>
                    </form>
                </div>
                <!-- Modal -->
                <div id="delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" name="cancel">×</button>
                        <h3 id="myModalLabel">Brisanje korisnika</h3>
                    </div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="modal-body">
                            <input type="hidden" id="userIdForDelete" name="userIdForDelete"/>
                            Da li ste sigurni da želite da obrišete korisnika :
                            <span id="userForDeleteName"></span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"> Poništi</button>
                            <button class="btn btn-primary" id="confirmation" type="submit" name="deleteUser">Obriši</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /row -->

        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->
<!-- Le javascript
================================================== -->


<?php
include $footerMenuLayout;
?>

<script>
    function edit(val) {
        document.cookie = "currentRank=''";
        var name = document.getElementById('name' + val).textContent;
        var lastname = document.getElementById('lastname' + val).textContent;
        var arenausername = document.getElementById('arenausername' + val).textContent;
        var summonername = document.getElementById('summonername' + val).textContent;
        var rankname = document.getElementById('rankname' + val).textContent;
        var positionname = document.getElementById('positionname' + val).textContent;
        var phone = document.getElementById('phone' + val).textContent;
        var userid = document.getElementById('userId' + val).value;
        document.getElementById('firstname').setAttribute("value", name);
        document.getElementById('lastname').setAttribute("value", lastname);
        document.getElementById('username').setAttribute("value", arenausername);
        document.getElementById('sumname').setAttribute("value", summonername);
        document.getElementById('phone').setAttribute("value", phone);
        document.getElementById('user').setAttribute("value", userid);

        $('#userrank').val(rankname);


        console.log(userid);
    }

    function deleteUser(val) {
        var usernameDelete = document.getElementById('arenausername' + val).textContent;
        var userIdDelete = document.getElementById('userId'+val).value;
        document.getElementById('userIdForDelete').setAttribute("value", userIdDelete);
        document.getElementById('userForDeleteName').innerHTML = usernameDelete.bold();

    }


</script>
</body>
</html>
