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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
          rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/pages/dashboard.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a
                class="brand" href="index.php">eSports Arena</a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="icon-user"></i><?php echo "$currentWorker->name $currentWorker->lastname" ?><b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="profil.html">Profil</a></li>
                            <li><a href="logout.php">Izloguj se</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-search pull-right">
                    <input type="text" class="search-query" placeholder="Pretraži">
                </form>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!-- /container -->
    </div>
    <!-- /navbar-inner -->
</div>
<!-- /navbar -->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="active"><a href="index.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a></li>
                <li><a href="kraj_smene.php"><i class="icon-list-alt"></i><span>Kraj smene</span> </a></li>
                <li><a href="lol_klub.php"><i class="icon-group"></i><span>LOL klub</span> </a></li>
                <li><a href="lol_takmicenje.php"><i class="icon-trophy"></i><span>LOL takmičenje</span> </a></li>
                <li><a href="lucky_numbers.html"><i class="icon-gift"></i><span>Lucky Numbers</span> </a></li>
                <li><a href="bonus_sati.php"><i class="icon-time"></i><span>Bonus sati</span> </a></li>
                <li><a href="magacin.php"><i class="icon-truck"></i><span>Magacin</span> </a></li>

            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->
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
                                <li>

                                    <div class="news-item-date"><span class="news-item-day">17</span> <span
                                            class="news-item-month">Mar</span></div>
                                    <div class="news-item-detail"><a
                                            href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title"
                                            target="_blank">Thursday Roundup # 40</a>
                                        <p class="news-item-preview"> This is our web design and development news series
                                            where we share our favorite design/development related articles, resources,
                                            tutorials and awesome freebies. </p>
                                    </div>

                                </li>
                                <li>

                                    <div class="news-item-date"><span class="news-item-day">15</span> <span
                                            class="news-item-month">Jun</span></div>
                                    <div class="news-item-detail"><a
                                            href="http://www.egrappler.com/retina-ready-responsive-app-landing-page-website-template-app-landing/"
                                            class="news-item-title" target="_blank">Retina Ready Responsive App Landing
                                            Page Website Template – App Landing</a>
                                        <p class="news-item-preview"> App Landing is a retina ready responsive app
                                            landing page website template perfect for software and application
                                            developers and small business owners looking to promote their iPhone, iPad,
                                            Android Apps and software products.</p>
                                    </div>

                                </li>
                                <li>

                                    <div class="news-item-date"><span class="news-item-day">29</span> <span
                                            class="news-item-month">Oct</span></div>
                                    <div class="news-item-detail"><a
                                            href="http://www.egrappler.com/open-source-jquery-php-ajax-contact-form-templates-with-captcha-formify/"
                                            class="news-item-title" target="_blank">Open Source jQuery PHP Ajax Contact
                                            Form Templates With Captcha: Formify</a>
                                        <p class="news-item-preview"> Formify is a contribution to lessen the pain of
                                            creating contact forms. The collection contains six different forms that are
                                            commonly used. These open source contact forms can be customized as well to
                                            suit the need for your website/application.</p>
                                    </div>

                                </li>
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
                                <tr>
                                    <td class="center"> 1</td>
                                    <td> Chumpitas</td>
                                    <td class="center"> 300</td>
                                    <td class="center"> 20h</td>
                                    <td class="center"> 360</td>
                                </tr>
                                <tr>
                                    <td class="center"> 1</td>
                                    <td> Chumpitas</td>
                                    <td class="center"> 300</td>
                                    <td class="center"> 20h</td>
                                    <td class="center"> 360</td>
                                </tr>
                                <tr>
                                    <td class="center"> 1</td>
                                    <td> Chumpitas</td>
                                    <td class="center"> 300</td>
                                    <td class="center"> 20h</td>
                                    <td class="center"> 360</td>
                                </tr>
                                <tr>
                                    <td class="center"> 1</td>
                                    <td> Chumpitas</td>
                                    <td class="center"> 300</td>
                                    <td class="center"> 20h</td>
                                    <td class="center"> 360</td>
                                </tr>
                                <tr>
                                    <td class="center"> 1</td>
                                    <td> Chumpitas</td>
                                    <td class="center"> 300</td>
                                    <td class="center"> 20h</td>
                                    <td class="center"> 360</td>
                                </tr>
                                <tr>
                                    <td class="center"> 1</td>
                                    <td> Chumpitas</td>
                                    <td class="center"> 300</td>
                                    <td class="center"> 20h</td>
                                    <td class="center"> 360</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

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
                                $allresults = $result->getSumResult();
                                $page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
                                $perPage = 3;
                                $count = count($allresults);
                                $pagination = new pagination($page, $perPage, $count);
                                $allresults = $result->getSumResultPagination($pagination->offset(), $perPage);
                                foreach ($allresults as $item) { ?>

                                    <tr>
                                        <td class="center"> 1</td>
                                        <td><?php echo $item->uname ?></td>
                                        <td class="center"><?php echo $item->heroname ?></td>
                                        <td class="center"><?php echo $item->value ?></td>

                                    </tr>
                                <?php }
                                if ($pagination->totalPages() > 1) { ?>
                                    <tr>

                                        <?php if ($pagination->hasPreviousPage()) { ?>
                                            <a href="index.php?page=<?php $pagination->previousPage()?>">&laquo; Prethodna</a>
                                        <?php
                                        } ?>

                                        <?php if ($pagination->hasNextPage()) { ?>
                                            <a href="index.php?page=<?php $pagination->nextPage()?>"> Sledeća</a>
                                            <?php
                                        } ?>
                                    </tr>
                                    <?php
                                } ?>

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3>Rezervacije</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="#rezervacija" role="button" class="btn" data-toggle="modal">Dodaj novu
                                    rezervaciju</a>

                                <!-- Modal -->
                                <div id="rezervacija" class="modal hide fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Unos nove rezervacije</h3>
                                    </div>
                                    <div class="modal-body">
                                        <input type="datetime-local"/><br/>
                                        <input type="text" id="user_reservation" name="username" value=""
                                               placeholder="eSports Arena Username" class="login"/><br/>
                                        <input type="text" id="user_pc" name="pc" value="" placeholder="PC"
                                               class="login"/>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                        <button class="btn btn-primary">Napravi rezervaciju</button>
                                    </div>
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
                                foreach ($allreservations as $item) {
//                                    new DateTime($item->timedate) >= $currentdate and
                                    if ($item->confirmed == null) {
                                        ?>
                                        <tr>
                                            <td class="center"><?php echo $item->date ?></td>
                                            <td class="center"><b><?php echo $item->time ?></b></td>
                                            <td class="center"><b><?php echo $item->reservation ?></b></td>
                                            <td><?php echo $item->username ?></td>
                                            <td class="td-actions">
                                                <div>
                                                    <!-- Button to trigger modal -->
                                                    <a href="#izvrseno" role="button" class="btn btn-small btn-success" data-toggle="modal"><i class="btn-icon-only icon-ok"> </i></a>
                                                    <a href="#ponisti" role="button" class="btn btn-small btn-danger" data-toggle="modal"><i class="btn-icon-only icon-remove"> </i></a>


                                                </div> <!-- /controls -->
                                            </td>
                                        </tr>
                                    <?php }
                                }
                                unset($res, $allreservations); ?>

                                <!-- Modal -->
                                <div id="izvrseno" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Potvrda rezervacije</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>Rezervacija je izvršena i kompjuteri su izdati.</p>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">
                                            Poništi
                                        </button>
                                        <button class="btn btn-primary">Potvrdi</button>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div id="ponisti" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Otkazivanje rezervacije</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>Rezervacija ne može biti izvršena, pa se otkazuje.</p>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">
                                            Poništi
                                        </button>
                                        <button class="btn btn-primary">Potvrdi</button>
                                    </div>
                                </div>
                                </tbody>
                            </table>

                        </div>

                    </div>

                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-money"></i>
                            <h3>Dugovanja</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="#dugovanje" role="button" class="btn" data-toggle="modal">Dodaj novo dugovanje</a>

                                <!-- Modal -->
                                <div id="dugovanje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Unos novog dugovanja</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                                        <button class="btn btn-primary" type="submit" name="saveCredit">Unesi
                                            dugovanje
                                        </button>
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
                                    <th data-sortable="true"> Uk. Iznos</th>
                                    <th data-sortable="true"> Koliko dugo duguje</th>
                                    <th> Akcija</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $maxDay = '';
                                $sumCredit = 0;
                                foreach ($userCredits as $item) {
                                    if ($item->value > 0) { ?>
                                        <tr>
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
                                    <?php }
                                } ?>
                                <!-- Modal -->
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div id="vracanje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×
                                            </button>
                                            <h3 id="myModalLabel">Unos novog dugovanja</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p id="userCredit"></p>
                                            <input type="hidden" name="currentUserName" id="currentUserName" value=""/>
                                            <input type="hidden" name="currentUserId" id="currentUserId" value=""/>
                                            <input type="number" id="amountDebit" name="amountDebit" value="" placeholder="Iznos vraćenog duga" class="login"
                                                   onchange="calculate()"/>
                                            <p id="currentDebit"></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">
                                                Poništi
                                            </button>
                                            <button class="btn btn-primary" name="reduceCredit" type="submit">Unesi izmenu</button>
                                        </div>
                                    </div>
                                </form>
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div class="widget widget-nopad">
                        <div class="widget-header"><i class="icon-list-alt"></i>
                            <h3> Statistika za Mart 2017. </h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <div class="widget big-stats-container">
                                <div class="widget-content">
                                    <div id="big_stats" class="cf">
                                        <div class="stat"><i class="icon-time"></i><label>Lucky numbers</label> <span
                                                class="value">342h</span></div>
                                        <!-- .stat -->

                                        <div class="stat"><i class="icon-thumbs-up-alt"></i><label>FB Likes</label>
                                            <span class="value">3.423</span></div>
                                        <!-- .stat -->

                                        <div class="stat"><i class="icon-time"></i><label>Bonus sati</label> <span
                                                class="value">342h</span></div>
                                        <!-- .stat -->

                                        <div class="stat"><i class="icon-user"></i><label>Broj korisnika</label> <span
                                                class="value">2.673</span></div>
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


    function calculate() {
        var x = document.getElementById("amountDebit").value;
        var y = document.getElementById("currentDebit").value;
        var rest = y - x;
        console.log(rest);
        document.getElementById("currentDebit").innerHTML = "Nakon uplate stanje duga je " + rest + " Din."
    }
</script>


</body>
</html>
