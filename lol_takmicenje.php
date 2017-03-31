<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$step = 4;

$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span6">

                    <?php include $tableCompetitionByUser; ?>
                </div>


                <div class="span6">
                    <?php include $tableCompetitionByHero; ?>
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
</script>
<script>


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

        var pagenum = table + 'PageNum';
        document.getElementById(pagenum).innerHTML = page + '/' + maxNumPage;

//        var currclassleft = table + 'left';
//        var currclassright = table + 'right';
//        if (page == 1) {
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
</script><!-- /Calendar -->
</body>
</html>
