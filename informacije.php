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

$wrk = new worker();
$currentWorker = $wrk->getWorkerById($session->userid);


if (isset($_POST["saveInfo"])) {
    $newinfo = new info();
    $newinfo->addNewInformation($_POST["date"], $_POST["tittle"], $_POST["infoText"], $session->userid);
    unset($newinfo);
    header("Location:informacije.php");
}

$dateNow = new DateTime();
$dateNow = $dateNow->format("Y-m-d");



$currentpage =  basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <?php $info = new info();
                    $page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
                    $allInfo = $info->getAllInformations();
                    $perPage = 10;
                    $count = count($allInfo);
                    $pagination = new pagination($page, $count, $perPage);
                    $allInfo = $info->getAllInformations($pagination->offset(), $perPage); ?>


                    <div class="widget widget-nopad">
                        <div class="widget-header"><i class="icon-list-alt"></i>
                            <h3> Važne informacije
                                <?php if ($pagination->hasPreviousPage()) { ?>
                                    <a href="informacije.php?page=<?php echo $pagination->previousPage() ?>" value="<?php echo $pagination->previousPage() ?>" id="leftSide" name="leftSide"><i
                                            class="icon-chevron-left"></i></a>
                                <?php }
                                if ($pagination->hasNextPage()) { ?>
                                    <a href="informacije.php?page=<?php echo $pagination->nextPage() ?>" value="<?php echo $pagination->previousPage() ?>" name="rightSide" id="rightSide"><i
                                            class="icon-chevron-right"></i></a>
                                <?php } ?>
                            </h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="#info" role="button" class="btn" data-toggle="modal">Dodaj novu informaciju</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <ul class="news-items">

                                <?php
                                foreach ($allInfo as $item) { ?>

                                    <li>
                                        <div class="news-item-date"><span class="news-item-day"><?php echo $item->tmpdate; ?></span> <span class="news-item-month"><?php echo $item->month; ?></span>
                                        </div>
                                        <div class="news-item-detail"><a href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title"
                                                                         target="_blank"><?php echo $item->tittle; ?></a>
                                            <p class="news-item-preview"><?php echo $item->text; ?></p>
                                        </div>
                                    </li>


                                    <?php
                                }
                                unset($allInfo, $info); ?>

                            </ul>
                        </div>
                        <!-- /widget-content -->

                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <?php $tmpwrk = $wrk->getAdmin();
                            if ($currentWorker->workertypeid == $tmpwrk->id) { ?>

                                <div id="info" class="modal hide fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Unos nove informacije</h3>
                                    </div>
                                    <div class="modal-body">
                                        <input type="date" name="date" value="<?php echo $dateNow ?>" required/><br/>
                                        <input type="text" name="tittle" placeholder="Naslov" required/><br/>
                                        <input type="text" name="infoText" value="" placeholder="Text vesti" required max="1000"/>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                        <button class="btn btn-primary" type="submit" name="saveInfo">Sačuvaj informaciju</button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div id="info" class="modal hide fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Nemate privilegije da dodajete informacije molimo Vas ulogujte se kao administrator</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                    </div>
                                </div>

                            <?php }
                            unset($tmpwrk); ?>
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
</body>
</html>
