<?php

include(join(DIRECTORY_SEPARATOR, array('..','includes', 'init.php')));


if (!$session->isLoggedIn()) {
    redirectTo("login.php");
}

if (isset($_POST["logout"])) {
    echo "Izlogovali smo se <br>";
    $session->logout();
    header("Location:index.php");
}


$wrk = new worker();
$currentWorker = $wrk->getWorkerById($session->userid);

$usr = new credit();
$userCredits = $usr->getAllUserCredits();


if (isset($_POST["saveCredit"])) {
    $code = explode('__', $_POST["selectUser"]);
    $user = $code[0];
    $usr->addUserCredit($user, $_POST["amountChosen"], $session->userid);
    unset($usr);
    header("Location:index.php");
}


if (isset($_POST['reduceCredit'])) {
    $reducedCredit = abs($_POST['amountDebit']) * -1;
    $currentuser = $_POST['currentUserId'];

    $usr->addUserCredit($currentuser, $reducedCredit, $session->userid);
    unset($usr);
    header("Location:index.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>eSports Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
          rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/pages/dashboard.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-trophy"></i>
                            <h3>LOL takmičenje</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="unos_rezultata.php" role="button" class="btn">Dodaj rezultate</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="20"> RB</th>
                                    <th> Username</th>
                                    <th width="150" class="center"> Champion</th>
                                    <th width="60"> Br. Pobeda</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $result = new result();
                                $page = 1;
                                $i = 1;
                                $step = 3;
                                $allresults = $result->getSumResult();
                                foreach ($allresults as $item) { ?>

                                    <tr id="<?php echo $i?>" >
                                        <td class="center"> 1</td>
                                        <td><?php echo $item->uname ?></td>
                                        <td class="center"><?php echo $item->heroname ?></td>
                                        <td class="center"><?php echo $item->value ?></td>

                                    </tr>
                                    <?php $i++;
                                } ?>
                                </tbody>
                            </table>

                            <?php
                            $countItems = $i;
                            if ($countItems > $step) {
                                $numPages = ceil($countItems / $step); ?>
                                <ul class="pagination pagination-sm">
                                    <?php for ($j = 1; $j <= $numPages; $j++) { ?>
                                        <li><a href="#" onclick="pagination(<?php echo "$j,$step,$countItems"?>)"> <?php echo $j ?></a></li>
                                    <?php } ?>
                                </ul>



                            <?php } ?>


                        </div>

                    </div>

                </div>

<!-- /main -->
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/excanvas.min.js"></script>
<script src="../js/chart.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../js/full-calendar/fullcalendar.min.js"></script>

<script src="../js/base.js"></script>
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


    function calculate() {
        var x = document.getElementById("amountDebit").value;
        var y = document.getElementById("currentDebit").value;
        var rest = y - x;
        console.log(rest);
        document.getElementById("currentDebit").innerHTML = "Nakon uplate stanje duga je " + rest + " Din."
    }

    function pagination($page, $step, $countItems) {
        for(var $k=1; $k<$countItems; $k++) {
            console.log($k);
            if ($k > ($page -1)*$step && $k <= $page * $step) {
                document.getElementById($k).style.display = "block";
            } else
            {
                document.getElementById($k).style.display = "none";
            }
        }
    }
</script>

<?php //echo ($i == 3)? "style=\"display:none;\"" : "" ?>
</body>
</html>
