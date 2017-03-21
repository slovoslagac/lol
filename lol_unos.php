<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


if (isset($_POST['user']) != ''){
    $tmpusr = new user();
    if (($tmpusr->getUserByUsername($_POST['username'])) == '') {

        $tmpusr->addUser($_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['sumname'], $_POST['userrank'], $_POST['userposition'], $_POST['phone']);
    } else {
        echo "Izabrani username se vec koristi, izaberite neki drugi";
        header("Location:lol_unos.php");
    }
}


//if (isset($_POST['user']) != ''){
//echo $_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['sumname'], $_POST['userrank'], $_POST['userposition'], $_POST['phone'];
//}
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
                                class="icon-user"></i> Stefan Dimitrijević <b class="caret"></b></a>
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
                <li class="active"><a href="lol_klub.html"><i class="icon-group"></i><span>LOL klub</span> </a></li>
                <li><a href="lol_takmicenje.html"><i class="icon-trophy"></i><span>LOL takmičenje</span> </a></li>
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


<div class="account-container register">

    <div class="content clearfix">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <h1>LOL klub - Novi član</h1>

            <div class="login-fields">

                <p>Obavezno popuniti sva polja:</p>

                <div class="field">
                    <label for="firstname">Ime:</label>
                    <input type="text" name="name" min="1" maxlength="50" placeholder="Ime" class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="lastname">Prezime:</label>
                    <input type="text" name="lastname" min="1" maxlength="50" placeholder="Prezime" class="login"
                           required/>
                </div> <!-- /field -->


                <div class="field">
                    <label for="email">eSports Arena Username:</label>
                    <input type="text" name="username" min="1" maxlength="50" placeholder="eSports Arena username"
                           class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="confirm_password">Telefon:</label>
                    <input type="tel" name="phone" min="1" maxlength="50" placeholder="Telefon" class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Summonner name:</label>
                    <input type="text" name="sumname" min="1" maxlength="50" placeholder="Summoner name" class="login"
                           required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Rank:</label>
                    <select name="userrank">
                        <?php $rnk = new rank();
                        $alltmprnk = $rnk->getAllRanks();
                        foreach ($alltmprnk as $item) { ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                </div> <!-- /field -->
                <div class="field">
                    <label for="password">Pozicija:</label>
                    <fieldset>

                        <legend>Pozicija</legend>
                        <?php $pos = new position();
                        $alltmppos = $pos->getAllPositions();
                        foreach ($alltmppos as $item) { ?>
                            <input type="checkbox" name="userposition" value="<?php echo $item->id ?>">
                            <small><?php echo $item->name ?></small>
                        <?php } ?>
                    </fieldset>
                </div> <!-- /field -->


            </div> <!-- /login-fields -->

            <div class="login-actions">


                <input name="user" class="button btn btn-primary btn-large" type="submit" value="Registruj člana"></input>

            </div> <!-- .actions -->

        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
