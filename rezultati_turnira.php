<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

//tournament_data
$tournament_id = 4;
$tournament_type = 2;
$matchurl = "http://localhost/levelup/api/apiGetMatchesbyTournament.php?tournament=$tournament_id";
$tournamenturl = "http://localhost/levelup/api/apiGetTournamentDetails.php?tournament=$tournament_id";
$tournamentMatches = json_decode(file_get_contents($matchurl));
$tournamentDetails = json_decode(file_get_contents($tournamenturl));
$newmatches = array();
$oldmatches = array();


foreach ($tournamentMatches as $item) {
    if ($item->positionroundone != '' || $item->positionroundtwo != '' || $item->positionroundthree != '') {
        array_push($oldmatches, $item);
    } else {
        array_push($newmatches, $item);
    }
}

if (isset($_POST['updatepubg'])) {
    $matchid = $_POST['updatematchid'];
    $roundid = $_POST['updateroundid'];
    $kill = $_POST['killnumber'];
    $position = $_POST['position'];
    $workerid = $session->userid;
    $url = "http://localhost/levelup/api/apiSetNewResult.php?matchid=$matchid&roundid=$roundid&position=$position&killnumber=$kill&worker=$workerid";

    file_get_contents($url);
    header("Refresh: 0;");
}


?>
<div class="main">
    <div class="main-inner">
        <div class="container">


            <div class="row">
                <?php if ($tournament_type == 1) { ?>
                    <div class="span6">
                        <div class="widget widget-table action-table">
                            <div class="widget-header"><i class="icon-trophy"></i>
                                <h3><?php echo $tournamentDetails->tournamentname . ' - ' . $tournamentDetails->starttime ?></h3>
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="center"> Igrač</th>
                                        <th class="center"> Rezultat</th>
                                        <th class="center"> Unos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($newmatches as $item) { ?>
                                        <tr>
                                            <td class="center" width="280"><b><?php echo $item->hometeamname ?></b></td>
                                            <td class="center" width="80">Partija #<?php echo $item->entrynumber ?></td>
                                            <td class="center" width="80"><a href="#update_pugb" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                             onclick="updatepubg(<?php echo "$item->matchid,1,' $item->hometeamname #$item->entrynumber'" ?>)"><i
                                                        class="btn-icon-only icon-pencil"> </i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                    </tbody>
                                </table>

                            </div>

                        </div>

                    </div>
                <?php } elseif ($tournament_type == 2) { ?>
                    <div class="span6">
                        <div class="widget widget-table action-table">
                            <div class="widget-header"><i class="icon-trophy"></i>
                                <h3><?php echo $tournamentDetails->tournamentname . ' - ' . $tournamentDetails->starttime ?></h3>
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="center"> Tim 1</th>
                                        <th class="center"> Tim 2</th>
                                        <th class="center"> Rezultat</th>
                                        <th class="center"> Unos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($newmatches as $item) { ?>
                                        <tr>
                                            <td class="center" width="180"><b><?php echo $item->hometeamname ?></b></td>
                                            <td class="center" width="180"><b><?php echo $item->visitorteamname ?></b></td>
                                            <td class="center" width="80"><b><?php echo $item->val1.":". $item->val2 ?></b></td>
                                            <td class="center" width="80"><a href="#update_pugb" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                             onclick="updatepubg(<?php echo "$item->matchid,1,' $item->hometeamname #$item->entrynumber'" ?>)"><i
                                                        class="btn-icon-only icon-pencil"> </i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>

            <!-- /span6 -->
        </div>
        <div class="row">
            <?php if ($tournament_type == 1) { ?>
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3><?php echo $tournamentDetails->tournamentname . ' - ' . $tournamentDetails->starttime ?></h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="center"> Igrač</th>
                                    <th class="center"> Broj pozicije</th>
                                    <th class="center"> Broj kilova</th>
                                    <th class="center"> Unos</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($oldmatches as $item) { ?>
                                    <tr>
                                        <td class="center" width="180" colspan="2"><b><?php echo $item->hometeamname ?></b></td>
                                        <td class="center" width="180" colspan="2"><b>Partija #<?php echo $item->entrynumber ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="center" width="80">Game #1</td>
                                        <td class="center" width="80"><?php echo $item->positionroundone ?></td>
                                        <td class="center" width="80"><?php echo $item->killroundone ?></td>
                                        <td class="center" width="80"><a href="#update_pugb" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                         onclick="updatepubg(<?php echo "$item->matchid,1,' $item->hometeamname #$item->entrynumber'" ?>)"><i
                                                    class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="center" width="80">Game #2</td>
                                        <td class="center" width="80"><?php echo $item->positionroundtwo ?></td>
                                        <td class="center" width="80"><?php echo $item->killroundtwo ?></td>
                                        <td class="center" width="80"><a href="#update_pugb" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                         onclick="updatepubg(<?php echo "$item->matchid,2,' $item->hometeamname #$item->entrynumber'" ?>)"><i
                                                    class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="center" width="80">Game #3</td>
                                        <td class="center" width="80"><?php echo $item->positionroundthree ?></td>
                                        <td class="center" width="80"><?php echo $item->killroundthree ?></td>
                                        <td class="center" width="80"><a href="#update_pugb" role="button" class="btn btn-small btn-primary" data-toggle="modal"
                                                                         onclick="updatepubg(<?php echo "$item->matchid,3,' $item->hometeamname #$item->entrynumber'" ?>)"><i
                                                    class="btn-icon-only icon-pencil"> </i></a></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- Modal -->
                    <div id="update_pugb" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Unos rezultata meča</h3>
                            </div>

                            <div class="modal-body">

                                <div class="row">
                                    <div class="team1" id="name">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="result1">
                                        <input type="number" name="position" id="position" max="100"></div>
                                </div>
                                <div class="col-3">
                                    <div class="result1"><input type="number" name="killnumber" id="killnumber" max="99"></div>
                                </div>
                                <input type="hidden" id="updatematchid" name="updatematchid">
                                <input type="hidden" id="updateroundid" name="updateroundid">

                            </div>

                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                <button class="btn btn-primary" name="updatepubg">Potvrdi rezultat</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
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

    function updatepubg(id, roundid, name) {
        document.getElementById('name').innerText = name;
        document.getElementById('updatematchid').value = id;
        document.getElementById('updateroundid').value = roundid;
    }
</script>

<?php


include $footerMenuLayout;
?>
</body>
</html>