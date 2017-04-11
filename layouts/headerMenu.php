<?php

if (!$session->isLoggedIn()) {
    redirectTo("login.php");
}


if (isset($_POST["logout"])) {
    echo "Izlogovali smo se <br>";
    $session->logout();
    header("Location:index.php");
}

$link1 = "index.php";
$link2 = "kraj_smene.php";
$link3 = "lol_klub.php";
$link4 = "lol_takmicenje.php";
$link5 = "lucky_numbers.html";
$link6 = "bonus_sati.php";
$link7 = "magacin.php";
$link8 = "informacije.php";
$link9 = "kasa.php";

$wrk = new worker();
$currentWorker = $wrk->getWorkerById($session->userid);
$admin = $wrk->getAdmin();
$availableForms = array($link1, $link3, $link4, 'login.php', 'lol_unos.php', 'unos_rezultata.php');
$currentForm = basename($_SERVER["SCRIPT_FILENAME"]);

if ($currentWorker->workertypeid != $admin->id and !(in_array($currentForm, $availableForms))) {
    redirectTo("index.php");
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
    <link href="css/pages/signin.css" rel="stylesheet" type="text/css">
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
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <?php if ($currentWorker->workertypeid != $admin->id) { ?>
                    <li <?php echo ($link1 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link1 ?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a></li>
                    <li <?php echo ($link3 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link3 ?>"><i class="icon-group"></i><span>LOL klub</span> </a></li>
                    <li <?php echo ($link4 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link4 ?>"><i class="icon-trophy"></i><span>LOL takmičenje</span> </a></li>

                <?php } else { ?>

                    <li <?php echo ($link1 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link1 ?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a></li>
                    <li <?php echo ($link9 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link9 ?>"><i class="icon-shopping-cart"></i><span>Prodaja</span> </a></li>
                    <li <?php echo ($link2 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link2 ?>"><i class="icon-list-alt"></i><span>Kraj smene</span> </a></li>
                    <li <?php echo ($link3 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link3 ?>"><i class="icon-group"></i><span>LOL klub</span> </a></li>
                    <li <?php echo ($link4 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link4 ?>"><i class="icon-trophy"></i><span>LOL takmičenje</span> </a></li>
                    <li <?php echo ($link6 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link6 ?>"><i class="icon-time"></i><span>Bonus sati</span> </a></li>
                    <li <?php echo ($link7 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link7 ?>"><i class="icon-truck"></i><span>Magacin</span> </a></li>
                    <li <?php echo ($link8 == $currentpage) ? "class=\"active\"" : "" ?>><a href="<?php echo $link8 ?>"><i class="icon-truck"></i><span>Informacije</span> </a></li>

                <?php } ?>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
