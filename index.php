<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));
//
//
//if (!$session->isLoggedIn()) {
//    redirectTo("login.php");
//}
//
//if (isset($_POST["logout"])) {
//    echo "Izlogovali smo se <br>";
//    $session->logout();
//    header("Location:index.php");
//}
//
//
//$wrk = new worker();
//$currentWorker = $wrk->getWorkerById($session->userid);

$usr = new credit();
$userCredits = $usr->getSumAllUserCredits();

$u = new user();
$allusers = $u->getAllUsers();


//sredjivanje kredita

if (isset($_POST["saveCredit"])) {
    $code = explode('__', $_POST["selectUser"]);
    $user = $code[0];
    if ($user > 0) {
        $usr->addUserCredit($user, $_POST["amountChosen"], $session->userid);
        unset($usr);
        header("Location:index.php");
    }
}


if (isset($_POST['reduceCredit'])) {
    $reducedCredit = abs($_POST['amountDebit']) * -1;
    $currentuser = $_POST['currentUserId'];
    $usr->addUserCredit($currentuser, $reducedCredit, $session->userid);
    $currusrcredit = $usr->getSumUserCredit($currentuser);
    if ($currusrcredit->value == 0) {
        $usr->creditExpire($currentuser);
    }
    unset($usr, $currusrcredit);
    header("Location:index.php");
}


//Rezervacije

if (isset($_POST['confirmation'])) {
//    echo $_POST['confirmation'];
    $res = new reservation();
    $res->confirmReservation($_POST["confirmation"], $session->userid);
    unset($res);
    header("Location:index.php");
}


if (isset($_POST['cancelation'])) {
//    echo $_POST['confirmation'];
    $res = new reservation();
    $res->cancelReservation($_POST["cancelation"], $session->userid);
    unset($res);
    header("Location:index.php");
}


if (isset($_POST["makeReservation"])) {
    $res = new reservation();
    $res->addReservation($_POST["datetime"], $_POST["pc"], $_POST["user"], $session->userid);
    unset($res);
    header("Location:index.php");
}

$defDate = new DateTime();
$formatDate = $defDate->format("Y-m-d");
$date = $defDate->format("Y-m-d");
$time = $defDate->format("H:i");
$now = $date . "T" . $time;

// korak u paginaciji
$step = 8;



$currentpage =  basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-nopad">
                        <div class="widget-header"><i class="icon-list-alt"></i>
                            <h3> Važne informacije </h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <ul class="news-items">
                                <?php $info = new info();
                                $allInfo = $info->getAllInformations(0, 3);
                                foreach ($allInfo as $item) { ?>
                                    <li>

                                        <div class="news-item-date"><span class="news-item-day"><?php echo $item->tmpdate; ?></span> <span class="news-item-month"><?php echo $item->month; ?></span>
                                        </div>
                                        <div class="news-item-detail"><a href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title"
                                                                         target="_blank"><?php echo $item->tittle; ?></a>
                                            <p class="news-item-preview"><?php echo $item->text; ?></p>
                                        </div>

                                    </li>

                                <?php }
                                unset($allInfo, $info); ?>

                            </ul>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->
                </div>
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3>Bonus sati</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="20"> RB</th>
                                    <th> Username</th>
                                    <th width="40"> Br. Sati</th>
                                    <th width="40"> Bonus</th>
                                    <th width="40"> Očekivano</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 1; $i <= 10; $i++) { $numHours = $i * 15;?>
                                    <tr id="<?php echo "hour$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                                        <td class="center"> 1</td>
                                        <td> Chumpitas</td>
                                        <td class="center"><?php echo $numHours ?></td>
                                        <td class="center"><?php echo countBonus($i * 15) ?></td>
                                        <td class="center"> <?php echo nextBonus($numHours); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                                <?php
                                $countItems = $i - 1;

                                if ($countItems > $step) {
                                    $numPages = ceil($countItems / $step); ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="2" class="center">
                                            <?php for ($j = 1; $j <= $numPages; $j++) { ?>
                                                <a onclick="pagination(<?php echo "$j,$step,$countItems,'hour'" ?>)"> <?php echo $j ?></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tfoot>


                                <?php } ?>
                            </table>
                        </div>

                    </div>

                    <?php include $tableCompetitionByHero; ?>

                </div>


                <div class="span6">


                    <!--                    Pocetak rezervacija -->


                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3>Rezervacije </h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="#rezervacija" role="button" class="btn" data-toggle="modal">Dodaj novu rezervaciju</a>

                                <!-- Modal -->

                                <div id="rezervacija" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Unos nove rezervacije</h3>
                                    </div>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="modal-body">
                                            <input type="datetime-local" name="datetime" min="<?php echo $now ?>" value="<?php echo $now ?>" required/><br/>
                                            <select name="user" required>
                                                <?php foreach ($allusers as $item) { ?>
                                                    <option value="<?php echo $item->id ?>"><?php echo $item->arenausername ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="text" id="user_pc" name="pc" value="" placeholder="11,12,13,14" class="login" required/>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                            <button class="btn btn-primary" type="submit" name="makeReservation">Napravi rezervaciju</button>
                                        </div>
                                    </form>
                                </div>

                            </div> <!-- /controls -->
                            <!--<div class="add"><i class="icon-plus-sign"></i>&nbsp;&nbsp;dodaj novu rezervaciju</div>-->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th> Datum</th>
                                    <th> Vreme</th>
                                    <th> Kompjuter(i)</th>
                                    <th> Username</th>
                                    <th> Akcija</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $currentdate = new DateTime();
                                $res = new reservation();
                                $allreservations = $res->getAllReservations();
                                $i = 1;
                                foreach ($allreservations as $item) {
                                    if ($item->confirmed == null) {
                                        ?>
                                        <tr id="<?php echo "reserv$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                                            <td class="center"><?php echo $item->date ?></td>
                                            <td class="center"><b><?php echo $item->time ?></b></td>
                                            <td class="center"><b><?php echo $item->reservation ?></b></td>
                                            <td><?php echo $item->username ?></td>
                                            <td class="td-actions">
                                                <div>
                                                    <!-- Button to trigger modal -->
                                                    <a href="#izvrseno" role="button" class="btn btn-small btn-success" data-toggle="modal" onclick="confirmReservation(<?php echo $item->id ?>)"><i
                                                            class="btn-icon-only icon-ok"> </i></a>
                                                    <a href="#ponisti" role="button" class="btn btn-small btn-danger" data-toggle="modal" onclick="cancelReservation(<?php echo $item->id ?>)"><i
                                                            class="btn-icon-only icon-remove"> </i></a>


                                                </div> <!-- /controls -->
                                            </td>
                                        </tr>
                                        <?php $i++;
                                    }
                                }
                                unset($res, $allreservations); ?>


                                </tbody>

                                <?php
                                $countItems = $i - 1;

                                if ($countItems > $step) {
                                    $numPages = ceil($countItems / $step); ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="right">
                                            <?php for ($j = 1; $j <= $numPages; $j++) { ?>
                                                <a onclick="pagination(<?php echo "$j,$step,$countItems,'reserv'" ?>)"> <?php echo $j ?></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>

                    </div>

                    <!-- Modal -->
                    <div id="izvrseno" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Potvrda rezervacije</h3>
                        </div>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-body">
                                <p>Rezervacija je izvršena i kompjuteri su izdati.</p>

                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true"> Poništi</button>
                                <button class="btn btn-primary" type="submit" name="confirmation" id="confirmation">Potvrdi</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal -->
                    <div id="ponisti" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Otkazivanje rezervacije</h3>
                        </div>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-body">
                                <p>Rezervacija ne može biti izvršena, pa se otkazuje.</p>

                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                <button class="btn btn-primary" name="cancelation" id="cancelation">Otkaži rezervaciju</button>
                            </div>
                        </form>
                    </div>


                    <!--Kraj rezervacija-->


                    <!--Pocetak Dugovanja-->
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-money"></i>
                            <h3>Dugovanja</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="#dugovanje" role="button" class="btn" data-toggle="modal">Dodaj novo dugovanje</a>

                                <!-- Modal -->
                                <div id="dugovanje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Unos novog dugovanja</h3>
                                    </div>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="modal-body">
                                            <select id="selectUser" name="selectUser" onchange="myFunction()">
                                                <option value="0"></option>
                                                <?php foreach ($userCredits as $item) {
                                                    ?>
                                                    <option
                                                        value="<?php $credit = ($item->value == '') ? '0' : $item->value;
                                                        echo $item->id . '__' . $credit ?>"><?php echo $item->username ?></option>

                                                    <?php
                                                } ?>
                                            </select>
                                            <input type="number" id="amountChosen" name="amountChosen" value="" placeholder="Iznos dugovanja" class="login"/>
                                            <p id="amount"></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                            <button class="btn btn-primary" type="submit" name="saveCredit">Unesi dugovanje</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th> Igrač</th>
                                    <th> Uk. Iznos</th>
                                    <th> Koliko dugo duguje</th>
                                    <th> Akcija</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $maxDay = '';
                                $sumCredit = 0;
                                $i = 1;
                                foreach ($userCredits as $item) {
                                    if ($item->value > 0) {
                                        $sumCredit = $sumCredit + $item->value; ?>
                                        <tr id="<?php echo "credit$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                                            <td value="<?php echo $item->id ?>"><b><?php echo $item->username ?></b>
                                            </td>
                                            <td class="center"><?php echo "$item->value Din" ?></td>
                                            <td><?php echo ($item->num_days > 1) ? "$item->num_days dana" : ($item->num_days == 1) ? "$item->num_days dan" : "Od danas" ?></td>
                                            <td class="td-actions">
                                                <div>
                                                    <!-- Button to trigger modal -->
                                                    <a data-toggle="modal" href="#vracanje" id="updateUser<?php echo $item->id ?>" data-id="<?php echo $item->id ?>" role="button"
                                                       class="btn btn-small btn-success"
                                                       onclick="updateUser('<?php echo $item->id . "__" . $item->username . "__" . $item->value ?>')">
                                                        <i class="btn-icon-only icon-ok"></i></a>
                                                    <!--        <button href="#vracanje" role="button" class="btn btn-small btn-success"data-toggle="modal"><i class="btn-icon-only icon-ok"> </i></button>-->

                                                </div> <!-- /controls -->
                                            </td>
                                        </tr>
                                        <?php $i++;
                                    }
                                } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="center"><b><?php echo "$sumCredit Din" ?></b></td>
                                </tr>
                                </tbody>
                                <?php
                                $countItems = $i - 1;

                                if ($countItems > $step) {
                                    $numPages = ceil($countItems / $step); ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="right">
                                            <?php for ($j = 1; $j <= $numPages; $j++) { ?>
                                                <a onclick="pagination(<?php echo "$j,$step,$countItems,'credit'" ?>)"> <?php echo $j ?></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="vracanje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Unos novog dugovanja</h3>
                        </div>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-body">
                                <p id="userCredit"></p>
                                <input type="hidden" name="currentUserName" id="currentUserName" value=""/>
                                <input type="hidden" name="currentUserId" id="currentUserId" value=""/>
                                <input type="number" id="amountDebit" name="amountDebit" value="" placeholder="Iznos vracenog duga" class="login" onchange="calculate()"/>
                                <p id="currentDebit"></p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                <button class="btn btn-primary" name="reduceCredit" type="submit">Unesi izmenu</button>
                            </div>
                        </form>
                    </div>

                    <!--Kraj Dugovanja-->
                    <div class="widget widget-nopad">
                        <div class="widget-header"><i class="icon-list-alt"></i>
                            <h3> Statistika za Mart 2017. </h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <div class="widget big-stats-container">
                                <div class="widget-content">
                                    <div id="big_stats" class="cf">
                                        <div class="stat"><i class="icon-time"></i><label>Raspored</label> <span class="value">342h</span></div>
                                        <!-- .stat -->

                                        <div class="stat"><i class="icon-thumbs-up-alt"></i><label>FB Likes</label> <span class="value">3.423</span></div>
                                        <!-- .stat -->

                                        <div class="stat"><i class="icon-time"></i><label>Bonus sati</label> <span class="value">342h</span></div>
                                        <!-- .stat -->

                                        <div class="stat"><i class="icon-user"></i><label>Broj korisnika</label> <span class="value">2.673</span></div>
                                        <!-- .stat -->
                                    </div>
                                </div>
                                <!-- /widget-content -->

                            </div>
                        </div>
                    </div>
                    <!-- /widget -->
                </div>

                <!-- /span12 -->

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
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/excanvas.min.js"></script>
<script src="js/chart.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>

<script src="js/base.js"></script>
<script>

    var lineChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                data: [65, 59, 90, 81, 56, 55, 40]
            },
            {
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                data: [28, 48, 40, 19, 96, 27, 100]
            }
        ]

    }

    var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


    var barChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                data: [65, 59, 90, 81, 56, 55, 40]
            },
            {
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 96, 27, 100]
            }
        ]

    }

    $(document).ready(function () {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                        true // make the event "stick"
                    );
                }
                calendar.fullCalendar('unselect');
            },
            editable: true,
            events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d + 5),
                    end: new Date(y, m, d + 7)
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d - 3, 16, 0),
                    allDay: false
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d + 4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false
                },
                {
                    title: 'EGrappler.com',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://EGrappler.com/'
                }
            ]
        });
    });
</script><!-- /Calendar -->

<script>
    function myFunction() {
        var code = document.getElementById("selectUser").value;
        var code = code.split("__");
        var maxAmount = 1000 - code[1];
        console.log(code);
        if (code[1] < 1000) {
            document.getElementById("amount").innerHTML = "Izabrani igrač ukupno duguje " + code[1] + " din od dozvoljenih 1.000 din.";
        } else {
            document.getElementById("amount").innerHTML = "Izabrani igrač vise ne moze da se zaduzuje";
        }
        $("#amountChosen").attr({
            "max": maxAmount
        });
    }
    ;

    //        function updateUser() {
    //            var currentvalue = document.getElementById("updateUser");
    //            console.log(currentvalue);
    //            $("#currentUser").attr({
    //                "value": currentvalue
    //            });
    //    }

    function updateUser(val) {
        var code = val.split("__");
        var id = code[0];
        var name = code[1];
        var credit = code[2];
        console.log(credit);
        document.getElementById("userCredit").innerHTML = "Vracanje duga za korisnika " + name.bold();
        document.getElementById("currentDebit").innerHTML = "Trenutno je korisnik " + name.bold() + " dužan " + credit.bold() + " Din.";
        $("#currentUserName").attr({
            "value": name
        });
        $("#currentUserId").attr({
            "value": id
        });
        $("#currentDebit").attr({
            "value": credit
        });
        $("#amountDebit").attr({
            "max": credit
        });

    }

    function confirmReservation($val) {
        $("#confirmation").attr({
            "value": $val
        });
    }

    function cancelReservation($val) {
        $("#cancelation").attr({
            "value": $val
        });
    }


    function calculate() {
        var x = document.getElementById("amountDebit").value;
        var y = document.getElementById("currentDebit").value;
        var rest = y - x;
//        console.log(rest);
        document.getElementById("currentDebit").innerHTML = "Nakon uplate stanje duga je " + rest + " Din."
    }

    function pagination($page, $step, $countItems, $type) {
        for (var $k = 1; $k <= $countItems; $k++) {
            var currclass = $type + $k;
            if ($k > ($page - 1) * $step && $k <= $page * $step) {
                document.getElementById(currclass).setAttribute("class", "");
            } else {
                document.getElementById(currclass).setAttribute("class", "hide");
            }

        }
    }


    function leftRight(val) {
        var code = val.split("__");
        var table = code[1];
        var side = code[0];
        var maxNumPage = code[2];
        var step = code[3];
        var numItems = code[4]
        var page = document.getElementById(table).value;
        if (side == 1) {
            if (page > 1) {
                page = parseInt(page) - 1;
            }
        } else {
            if (page < maxNumPage) {
                page = parseInt(page) + 1;
            }
        }

        document.getElementById(table).setAttribute("value", page);
        for (var k = 1; k <= numItems; k++) {
            var currclass = table + k;
            console.log(page);
            if (k > (page - 1) * step && k <= page * step) {
                document.getElementById(currclass).setAttribute("class", "");
            } else {
                document.getElementById(currclass).setAttribute("class", "hide");
            }

        }

//        var currclassleft = table +'left';
//        var currclassright = table +'right';
//        if(page == 1) {
//            document.getElementById(currclassleft).setAttribute("class", "hide");
//            document.getElementById(currclassright).setAttribute("class", "");
//        } else if (page == maxNumPage) {
//            document.getElementById(currclassleft).setAttribute("class", "");
//            document.getElementById(currclassright).setAttribute("class", "hide");
//        } else {
//            document.getElementById(currclassleft).setAttribute("class", "");
//            document.getElementById(currclassright).setAttribute("class", "");
//        }

    }


</script>


<?php //echo ($i == 3)? "style=\"display:none;\"" : "" ?>
</body>
</html>
