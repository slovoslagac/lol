<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmpresult = new cmp_results();
$fifamatches = $tmpresult->getMatchesFifa();
$fifaresults = $tmpresult->getResultsFifa();
$lolmatches = $tmpresult->getMatcheslol();
$lolresults = $tmpresult->getResultslol();


if (isset($_POST['savefifa'])) {
//    echo $_POST['result1'].'-'.$_POST['result2'];
    $rez1 = $_POST['result1'];
    $rez2 = $_POST['result2'];
    $id = $_POST['fifa'];
    $tmprez = new cmp_results();
    $tmprez->addresultfifa($id, $rez1, $rez2);
    unset($tmprez);

    $tmpmatch = new cmp_matches();
    $currentmatch = $tmpmatch->getmatch($id, 1);
    $hometest = $tmpmatch->gethomematchupdate($currentmatch->matchid, 1);
    $visitortest = $tmpmatch->getvisitormatchupdate($currentmatch->matchid, 1);

    ($rez1 > $rez2) ? $team= $currentmatch->homeparticipantid : $team = $currentmatch->visitorparticipantid;

    if($visitortest != '') {
        $updatematch = new cmp_matches();
        $matchid = $visitortest->matchid;
        $updatematch->updatevisitormatch($matchid,1,$team);
        unset($updatematch, $matchid);
    } elseif ($hometest != '') {
        $updatematch = new cmp_matches();
        $matchid = $hometest->matchid;
        $updatematch->updatehomematch($matchid,1,$team);
        unset($updatematch, $matchid);
    }

//    var_dump($visitortest);
//    var_dump($hometest);
//    var_dump($currentmatch);

    header("Refresh:0");

}


if (isset($_POST['savelol'])) {
//    echo $_POST['result1'].'-'.$_POST['result2'];
    $rez1 = $_POST['result1lol'];
    $rez2 = $_POST['result2lol'];
    $id = $_POST['lol'];
    $tmprez = new cmp_results();
    $tmprez->addresultfifa($id, $rez1, $rez2);
    unset($tmprez);

    $tmpmatch = new cmp_matches();
    $currentmatch = $tmpmatch->getmatch($id, 2);
    $hometest = $tmpmatch->gethomematchupdate($currentmatch->matchid, 2);
    $visitortest = $tmpmatch->getvisitormatchupdate($currentmatch->matchid, 2);

    ($rez1 > $rez2) ? $team= $currentmatch->homeparticipantid : $team = $currentmatch->visitorparticipantid;

    if($visitortest != '') {
        $updatematch = new cmp_matches();
        $matchid = $visitortest->matchid;
        $updatematch->updatevisitormatch($matchid,2,$team);
        unset($updatematch, $matchid);
    } elseif ($hometest != '') {
        $updatematch = new cmp_matches();
        $matchid = $hometest->matchid;
        $updatematch->updatehomematch($matchid,2,$team);
        unset($updatematch, $matchid);
    }

//    var_dump($visitortest);
//    var_dump($hometest);
//    var_dump($currentmatch);

    header("Refresh:0");

}


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3>Rezultati FIFA 18 turnira</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="center"> Domaćin</th>
                                    <th class="center"> Gost</th>
                                    <th class="center"> Rezultat</th>
                                    <th class="center"> Unos</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($fifamatches as $item) { ?>
                                    <tr>
                                        <td class="center" width="180"><b><?php echo $item->home ?></b></td>
                                        <td class="center" width="180"><b><?php echo $item->visitor ?></b></td>
                                        <td class="center" width="80"> - : -</td>
                                        <td class="center" width="80"><a href="#prijava_fifa" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                         onclick="addfifa(<?php echo "$item->id,'$item->home','$item->visitor'" ?>)"><i class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                <?php } ?>


                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- Modal -->
                    <div id="prijava_fifa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Unos rezultata meča</h3>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="modal-body">
                                <div class="team1" id="fifa1"></div>
                                <div class="vs">vs.</div>
                                <div class="team2" id="fifa2"></div>
                                <input type="hidden" id="fifa" name="fifa">
                                <div class="result1"><input type="number" name="result1" id="result1" onchange="checkfifa()"></div>
                                <div class="result2"><input type="number" name="result2" id="result2" onchange="checkfifa()"></div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                <button class="btn btn-primary" name="savefifa" id="savefifa" style="visibility: hidden">Potvrdi rezultat</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3>Rezultati LOL turnira</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="center"> Domaćin</th>
                                    <th class="center"> Gost</th>
                                    <th class="center"> Rezultat</th>
                                    <th class="center"> Unos</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($lolmatches as $item) { ?>
                                    <tr>
                                        <td class="center" width="180"><b><?php echo $item->home ?></b></td>
                                        <td class="center" width="180"><b><?php echo $item->visitor ?></b></td>
                                        <td class="center" width="80"> - : -</td>
                                        <td class="center" width="80"><a href="#prijava_lol" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                         onclick="addlol(<?php echo "$item->id,'$item->home','$item->visitor'" ?>)"><i class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                <?php } ?>

                            </table>

                        </div>

                    </div>

                    <!-- Modal -->
                    <div id="prijava_lol" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Unos rezultata meča</h3>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="modal-body">
                            <div class="team1" id="lol1"></div>
                            <div class="vs">vs.</div>
                            <div class="team2" id="lol2"></div>
                            <input type="hidden" id="lol" name="lol">
                            <div class="result1"><input type="number" name="result1lol" id="result1lol" onchange="checklol()"></div>
                            <div class="result2"><input type="number" name="result2lol" id="result2lol" onchange="checklol()"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                            <button class="btn btn-primary" name="savelol" id="savelol" style="visibility: hidden">Potvrdi rezultat</button>
                        </div>
                            </form>
                    </div>
                </div>

                <!-- /span6 -->
            </div>
            <div class="row">
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3>Uneti rezultati FIFA 18 turnira</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="center"> Domaćin</th>
                                    <th class="center"> Gost</th>
                                    <th class="center"> Rezultat</th>
                                    <th class="center"> Izmena</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($fifaresults as $item) { ?>
                                    <tr>
                                        <td class="center" width="180"><b><?php echo $item->home ?></b></td>
                                        <td class="center" width="180"><b><?php echo $item->visitor ?></b></td>
                                        <td class="center" width="80"> <?php echo $item->hres ?> : <?php echo $item->vres ?> </td>
                                        <td class="center" width="80"><a href="#prijava_fifa" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i
                                                    class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- Modal -->
                    <div id="" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Unos rezultata meča</h3>
                        </div>
                        <div class="modal-body">
                            <div class="team1">Marko Vujović</div>
                            <div class="vs">vs.</div>
                            <div class="team2">Boško Talančevski</div>
                            <div class="result1"><input type="number" name="result1"></div>
                            <div class="result2"><input type="number" name="result2"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                            <button class="btn btn-primary">Potvrdi rezultat</button>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3>Uneti LOL rezultati</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="center"> Domaćin</th>
                                    <th class="center"> Gost</th>
                                    <th class="center"> Rezultat</th>
                                    <th class="center"> Izmena</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($lolresults as $item) { ?>
                                    <tr>
                                        <td class="center" width="180"><b><?php echo $item->home ?></b></td>
                                        <td class="center" width="180"><b><?php echo $item->visitor ?></b></td>
                                        <td class="center" width="80"> <?php echo $item->hres ?> : <?php echo $item->vres ?> </td>
                                        <td class="center" width="80"><a href="#prijava_fifa" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i
                                                    class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- Modal -->
                    <div id="" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Unos rezultata meča</h3>
                        </div>
                        <div class="modal-body">
                            <div class="team1">Marko Vujović</div>
                            <div class="vs">vs.</div>
                            <div class="team2">Boško Talančevski</div>
                            <div class="result1"><input type="number" name="result1"></div>
                            <div class="result2"><input type="number" name="result2"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                            <button class="btn btn-primary">Potvrdi rezultat</button>
                        </div>
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
<!-- Le javascript
================================================== -->
<script>
    function addfifa(id, home, visitor) {
        console.log(id);
        document.getElementById('fifa1').innerText = home;
        document.getElementById('fifa2').innerText = visitor;
        document.getElementById('fifa').setAttribute('value', id);

    }

    function checkfifa() {
        var hr = document.getElementById('result1').value;
        var vr = document.getElementById('result2').value;
        console.log(hr, vr);
        if (hr >= 0 && vr >= 0 && hr != '' && vr != '' && hr != vr) {
            document.getElementById('savefifa').style.visibility = 'visible';
        } else {
            document.getElementById('savefifa').style.visibility = 'hidden';
        }
    }

    function addlol(id, home, visitor) {
        console.log(id);
        document.getElementById('lol1').innerText = home;
        document.getElementById('lol2').innerText = visitor;
        document.getElementById('lol').setAttribute('value', id);

    }

    function checklol() {
        var hr = document.getElementById('result1lol').value;
        var vr = document.getElementById('result2lol').value;
        console.log(hr, vr);
        if (hr >= 0 && vr >= 0 && hr != '' && vr != '' && hr != vr) {
            document.getElementById('savelol').style.visibility = 'visible';
        } else {
            document.getElementById('savelol').style.visibility = 'hidden';
        }
    }
</script>

<?php


include $footerMenuLayout;
?>
</body>
</html>