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

$prd = new products();
$allprd = $prd->getAllProducts();
$countprd = count($allprd);

if(isset($_POST["saveDellivery"]) != ''){
    $suplierid = $_POST["selectSupplier"];
    $date = new DateTime();
    $formatDate = $date->format("Y-m-d");
    if ($suplierid > 0) {
        $ord = new orders();
        $ord->addOrder($formatDate,$suplierid);
        $maxOrder = $ord->getMaxId();
        print_r($maxOrder);
        unset($ord);
        header("Location:unos_nabavke.php");
    }
    unset($suplierid);
//    echo $suplierid;
//    header("Location:unos_nabavke.php");
//    for ($j=1; $j <= $countprd; $j++){
//        $item = $_POST['item'.$j];
//        $value = $_POST['quantity'.$j];
//        $price = $_POST['order_price'.$j];
//        if($value >0 and $price >0) {
//            echo "$item - $price ($value)";
//        }
//
//    }


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
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.html">eSports Arena</a>
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
                <li><a href="index.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a></li>
                <li><a href="kraj_smene.php"><i class="icon-list-alt"></i><span>Kraj smene</span> </a></li>
                <li><a href="lol_klub.php"><i class="icon-group"></i><span>LOL klub</span> </a></li>
                <li><a href="lol_takmicenje.php"><i class="icon-trophy"></i><span>LOL takmičenje</span> </a></li>
                <li><a href="lucky_numbers.html"><i class="icon-gift"></i><span>Lucky Numbers</span> </a></li>
                <li><a href="bonus_sati.php"><i class="icon-time"></i><span>Bonus sati</span> </a></li>
                <li class="active"><a href="magacin.php"><i class="icon-truck"></i><span>Magacin</span> </a></li>
                <li><a href="informacije.php"><i class="icon-truck"></i><span>Informacije</span> </a></li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->


<div class="order-container register">

    <div class="content clearfix">

        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

            <h1>Unos nabavke</h1>

            <select id="selectSupplier" name="selectSupplier" >
                <option value="0"></option>
                <?php $sup = new suppliers(); $allsuppliers = $sup->getAllSuppliers(); foreach ($allsuppliers as $item) {
                    ?>
                    <option
                        value="<?php echo $item->id ?>"><?php echo $item->name ?></option>

                    <?php
                } unset ($sup, $allsuppliers)?>
            </select>

            <div class="login-fields">

                <p>Popuniti sve artikle koje su nabavljeni</p>

                <p><i>Cene uneti sa PDV-om</i></p>
                <?php
                $tittle = '';
                $i = 1;
                foreach ($allprd as $item) {
                    if ($tittle != $item->producttype) {
                        $tittle = $item->producttype ?>
                        <h2><?php echo $tittle ?></h2>
                    <?php } ?>
                    <div class="field">
                        <div class="order">
                            <div class="item"><?php echo $item->productname ?></div>
                            <input type="hidden" name="item<?php echo $i ?>" id="item<?php echo $i ?>" value="<?php echo $item->id ?>">
                            <input type="number" id="quantity<?php echo $i ?>" name="quantity<?php echo $i ?>" placeholder="kol" class="quantity" onchange="calculateSum(<?php echo $i ?>)"/>
                            <input type="number" step="0.01" id="order_price<?php echo $i ?>" name="order_price<?php echo $i ?>" placeholder="cena" class="order_price" onchange="calculateSum(<?php echo $i ?>)"/>
                            <div class="full_price" id="full_price<?php echo $i ?>"></div>
                        </div> <!-- /field -->
                    </div> <!-- /field -->
                    <?php $i++;
                } ?>


            </div> <!-- /login-fields -->

            <div class="login-actions">
				
                <span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4"/>
					<label class="choice" for="Field"> Potvrđujem da sam proverio/la sve količine i cene i da su sve ispravne.</label>
				</span>


                <button class="button btn btn-primary btn-large" type="submit" name="saveDellivery">Unesi nabavku</button>

            </div> <!-- .actions -->

        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

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


    function Supplier(){

    }
</script>


</body>

</html>
