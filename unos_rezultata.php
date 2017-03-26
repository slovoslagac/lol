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

if (isset($_POST['userResults']) != '') {
    $i = 0;
    while ($i < 10) {
        $val = $_POST['heroid'][$i];
        $usr = $_POST['userid'];
        $datetime = $_POST['datetime'][$i];
        $date = strstr($datetime, "T", true);
        $time = str_replace('T', '', strstr($datetime, "T", false));
        if ($val > 0 and $usr > 0 and $date != '' and $time != '') {
            $res = new result();
            $res->insertResult($usr, $val, $date, $time, $session->userid);
            unset($res);
        }
        $i++;
    }
    redirectTo("index.php");
}

$defDate = new DateTime();
$formatDate = $defDate->format("Y-m-d");
$date = $defDate->format("Y-m-d");
$time = $defDate->format("G:i");
$maxDate = $date . "T" . $time;

if (isset($_POST['deleteResult']) != '') {
    $id = $_POST['resultId'];
    $delResult = new result();
    $delResult->deleteResult($id);
    header('location:' . $_SERVER['PHP_SELF']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>eSports Arena</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/pages/signin.css" rel="stylesheet" type="text/css">

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
                                class="icon-user"></i><?php echo "$currentWorker->name $currentWorker->lastname" ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="profil.html">Profil</a></li>
                            <li><a href="javascript:;">Izloguj se</a></li>
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
                <li><a href="index.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a></li>
                <li><a href="kraj_smene.html"><i class="icon-list-alt"></i><span>Kraj smene</span> </a></li>
                <li><a href="lol_klub.php"><i class="icon-group"></i><span>LOL klub</span> </a></li>
                <li class="active"><a href="lol_takmicenje.html"><i class="icon-trophy"></i><span>LOL takmičenje</span>
                    </a></li>
                <li><a href="lucky_numbers.html"><i class="icon-gift"></i><span>Lucky Numbers</span> </a></li>
                <li><a href="bonus_sati.html"><i class="icon-time"></i><span>Bonus sati</span> </a></li>
                <li><a href="magacin.html"><i class="icon-truck"></i><span>Magacin</span> </a></li>

            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->


<div class="result-container register">

    <div class="content clearfix">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <h1>Unos rezultata</h1>

            <div class="login-fields">

                <p>Izaberi igrača za kojeg unosiš rezutate:</p>

                <div class="field">
                    <label for="password">Rank:</label>
                    <select name="userid">
                        <?php $user = new user();
                        $allUsers = $user->getAllUsers();
                        foreach ($allUsers as $item) { ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                </div> <!-- /field -->

                <p>Popuniti samo onoliko partija koliko je igrač prijavio</p>
                <?php for ($i = 1; $i < 11; $i++) { ?>
                    <div class="field">
                        <div class="champion">
                            <div class="rbr"><?php echo $i ?></div>
                            <label for="password">Rank:</label>
                            <select name="heroid[]">
                                <option value="0"></option>
                                <?php $hero = new hero();
                                $allHeros = $hero->getAllHeros();
                                foreach ($allHeros as $item) { ?>
                                    <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                <?php } ?>
                            </select>
                            <input type="datetime-local" name="datetime[]" placeholder="Date"
                                   value="<?php echo $maxDate ?>" max="<?php echo $maxDate ?>">
                        </div> <!-- /field -->
                    </div> <!-- /field -->
                <?php } ?>


            </div> <!-- /login-fields -->

            <div class="login-actions">
				
                <span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" required/>
					<label class="choice" for="Field">Potvrđujem da sam proverio/la sve prijavljene partije na sajtu www.lolskill.net i da su sve ispravne.</label>
				</span>

                <button class="button btn btn-primary btn-large" name="userResults" type="submit">Unesi rezultate</button>

            </div> <!-- .actions -->

        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
