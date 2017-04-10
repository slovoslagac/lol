<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/excanvas.min.js"></script>
<script src="js/chart.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>

<script src="js/base.js"></script>
<script src="js/signin.js"></script>
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

    //    function pagination($page, $step, $countItems, $type) {
    //        for (var $k = 1; $k <= $countItems; $k++) {
    //            var currclass = $type + $k;
    //            if ($k > ($page - 1) * $step && $k <= $page * $step) {
    //                document.getElementById(currclass).setAttribute("class", "");
    //            } else {
    //                document.getElementById(currclass).setAttribute("class", "hide");
    //            }
    //
    //        }
    //    }


    function leftRight(val) {
        var code = val.split("__");
        var table = code[1];
        var side = code[0];
        var maxNumPage = parseInt(code[2]);
        var step = code[3];
        var numItems = code[4]
        var page = document.getElementById(table).value;
        if (side == 1) {
            if (page > 1) {
                page = parseInt(page) - 1;
            }
        }
        else if (side==0) {
            page = 1;
        }
        else {
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


        for (var ak = 1; ak <= maxNumPage * step - numItems; ak++) {
            var addtable = 'add' + table + ak;
            console.log(addtable);
            console.log(page, maxNumPage);
            if (page == maxNumPage) {
                document.getElementById(addtable).setAttribute("class", "");
            } else {
                document.getElementById(addtable).setAttribute("class", "hide");
            }
        }


    }


</script>

<script>
    function calculateSum($val) {
        var curramount = 'quantity' + $val;
        var currentprice = 'order_price' + $val;
        var currentcost = 'full_price' + $val;
        var amount = document.getElementById(curramount).value;
        var price = document.getElementById(currentprice).value;

        var cost = amount * price;
        console.log(cost);
        if (amount > 0 && price > 0) {
            document.getElementById(currentcost).innerHTML = cost.toLocaleString();
        } else {
            document.getElementById(currentcost).innerHTML = '';
        }

        if (amount > 0) {
            document.getElementById(currentprice).required = true;
        } else {
            document.getElementById(currentprice).required = false;
        }

        if (price > 0) {
            document.getElementById(curramount).required = true;
        } else {
            document.getElementById(curramount).required = false;
        }

    }


    function Supplier() {

    }
</script>

