<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

//tournaments
$tmp_tournament = new cmp_tournament();
$alltournaments = $tmp_tournament->getall();

$tmp_cmp_player_new = new cmp_player();
$allteams = $tmp_cmp_player_new ->getall();
$allemail=array();
$allemailfull=array();


foreach($allteams as $item){
    $tmpval = "$item->name ($item->email)";
    array_push($allemailfull,$tmpval);
    array_push($allemail,$item->email);
}

$emailjson = json_encode($allemail);
$emailfulljson = json_encode($allemail);



if (isset($_POST['saveplayer'])) {
    $tmp_cmp_player = new cmp_player();
    $tournament_id = $_POST['tournament_id'];
    $tmpuser = '';
    if($_POST['users'] != '') {
        $olduserdata = (explode("(",$_POST['users']));
        $olduseremail = str_replace(")","",$olduserdata[1]);
        $tmpuser = $tmp_cmp_player->getattribute($olduseremail);
        echo $tmpuser->id;
    } else {
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $email_check = $tmp_cmp_player->getattribute($email);
        var_dump($email_check);
        if ($email_check == '') {
            $tmp_cmp_player->setattribute('username', $username);
            $tmp_cmp_player->setattribute('phone', $phone);
            $tmp_cmp_player->setattribute('email', $email);

            try {
                $tmp_cmp_player->addplayer();
            } catch (Exception $e) {
                logAction("Greska kod kreiranja novog tima", "'username', $username,'phone', $phone,'email', $email", 'cmp_team.txt');
            }
            logAction("Kreiranje novog tima", "'username', $username,'phone', $phone,'email', $email", 'cmp_team.txt');
            $tmpuser = $tmp_cmp_player->getattribute($email);
            unset($tmp_cmp_player);
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            logAction("Email vec postoji", "'username', $username,'phone', $phone,'email', $email", 'cmp_team.txt');
            echo "<script>alert('Uneta email adresa vec postoji');</script>";
//            echo "<meta http-equiv='refresh' content='0'>";

        }
    }
    $tmptrnmentry = new cmp_tournament_entry();
    $tmptrnmentry->setattribute('tournamentid', $tournament_id);
    $tmptrnmentry->setattribute('playerid', $tmpuser->id);
    $tmptrnmentry->addtournamententry();
    unset($tmptrnmentry, $tmpuser);
    echo "<meta http-equiv='refresh' content='0'>";
}


?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3>LevelUp! Turniri</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="novi_turnir.html" role="button" class="btn">Kreiraj novi turnir</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="center"> Turnir</th>
                                    <th class="center"> Igra</th>
                                    <th class="center"> Platforma</th>
                                    <th class="center"> Datum turnira</th>
                                    <th class="center"> Br. prijava</th>
                                    <th class="center"> Ukupan fond</th>
                                    <th class="center"> Prijava</th>
                                    <th class="center"> Izmena</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($alltournaments as $item) {

                                    ?>
                                    <tr>
                                        <td><a href="turnir_page.html"><?php echo $item->tournamentname?></a></td>
                                        <td class="center" width="80"><?php echo $item->gamename?></td>
                                        <td class="center" width="80"><?php echo $item->platformname?></td>
                                        <td class="center" width="160"><?php echo $item->starttime ?></td>
                                        <td class="center" width="80"></td>
                                        <td class="center" width="80"><b></b></td>
                                        <td class="center" width="80"><a href="#prijava" role="button" class="btn btn-small btn-primary" data-toggle="modal" onclick="userid(<?php echo $item->tournamentid?>)"><i class="btn-icon-only icon-user"> </i></a>
                                        </td>
                                        <td class="center" width="80"><a href="#izmena" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a>
                                        </td>
                                    </tr>



                                    <?php

                                }
                                ?>

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="prijava" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Registracija novog igrača za turnir FIFA 18</h3>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="tournament_id" name="tournament_id">
                                <input type="text" name="username" id="username" placeholder="Ime i prezime" required/><br/>
                                <input type="text" name="phone" id="phone" placeholder="Broj telefona" class="login" required/><br/>
                                <input type="email" name="email" id="email" placeholder="E-mail adresa" class="login" onchange="check()" required/>
                                <p id="alert" style="color: red;"></p>
                                <input type="file" id="files" name="files[]" multiple/>


                            </div>
                            <div class="modal-header">
                                <h3 id="myModalLabel">Odabir već registrovanog igrača</h3>
                            </div>
                            <div class="modal-body">
                                <input list="userslist" id="users" name="users" onchange="checkstatus()"/>
                                    <datalist id="userslist">
                                        <?php
                                        foreach($allemailfull as $email){ ?>
                                            <option value="<?php echo $email?>">
                                        <?php }?>
                                    </datalist>


                                <br/>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                <button class="btn btn-primary" name="saveplayer" id="saveplayer">Prijavi igrača na turnir</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /span6 -->
            </div>
            <!-- /row -->

        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->
<script>

    var emails = JSON.parse(<?php echo json_encode($emailjson) ?>);
    var emailsfull = JSON.parse(<?php echo json_encode($emailfulljson) ?>);
    console.log(emails);

    function check(){
        var email = document.getElementById('email').value;
        if(emails.indexOf(email) != -1){
            document.getElementById('saveplayer').style.visibility = "hidden";
            document.getElementById('alert').innerHTML = "e-mail adresa je zauzeta!"
        } else {
            document.getElementById('saveplayer').style.visibility = "visible";
            document.getElementById('alert').innerHTML = ""
        }
    }

    function checkstatus(){
        var selecteduser = document.getElementById('users').value;
        if(selecteduser != '') {
            console.log(selecteduser)
            document.querySelector("#username").required = false;
            document.querySelector("#email").required = false;
            document.querySelector("#phone").required = false;
        } else {
            document.querySelector("#username").required = true;
            document.querySelector("#email").required = true;
            document.querySelector("#phone").required = true;
        }
    }

    function userid(val){
        document.getElementById('tournament_id').setAttribute('value', val);

    }
</script>


<?php
include $footerMenuLayout;
?>
</body>
</html>
