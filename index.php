<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$u = new user();
$allusers = $u->getAllUsers();

$usr = new credit();
$userCredits = $usr->getSumAllUserCredits();
$userCreditCapable = $usr->getSumAllUserCreditsAvailable();
//sredjivanje kredita

if (isset($_POST["saveCredit"])) {

    $code = explode('__', $_POST["selectUser"]);
    $user = $code[0];
//    $selectedUser = $u->getUserByUsername($user);
//    $tmpuser = $selectedUser->id;
    if ($user != '') {
        try {
            $usr->addUserCredit($user, $_POST["amountChosen"], $session->userid);
            unset($usr);
            header("Location:index.php#credits");
        } catch (Exception $e) {
            logAction("Dodavanje dugova - error", "userid = $session->userid --- $e", 'error.txt');
        }
    }

}


if (isset($_POST['reduceCredit'])) {
    try {
        $reducedCredit = abs($_POST['amountDebit']) * -1;
        $currentuser = $_POST['currentUserId'];
        $usr->addUserCredit($currentuser, $reducedCredit, $session->userid);
        $currusrcredit = $usr->getSumUserCredit($currentuser);
        if ($currusrcredit->value == 0) {
            $usr->creditExpire($currentuser);
        }
        unset($usr, $currusrcredit);
        header("Location:index.php#credits");
    } catch (Exception $e) {
        logAction("Brisanje dugova - error", "userid = $session->userid --- $e", 'error.txt');
    }
}


//Rezervacije

if (isset($_POST['confirmation'])) {
    try {
        $res = new reservation();
        $res->confirmReservation($_POST["confirmation"], $session->userid);
        unset($res);
        header("Location:index.php#reservations");
    } catch (Exception $e) {
        logAction("Potvrda rezervacije - error", "userid = $session->userid --- $e", 'error.txt');
    }
}


if (isset($_POST['cancelation'])) {
    try {
        $res = new reservation();
        $res->cancelReservation($_POST["cancelation"], $session->userid);
        unset($res);
        header("Location:index.php#reservations");
    } catch (Exception $e) {
        logAction("Ponistavanje rezervacije - error", "userid = $session->userid --- $e", 'error.txt');
    }
}


if (isset($_POST["makeReservation"])) {
    try {
        $selectedUser = $u->getUserByUsername($_POST["user"]);
        $selectedUserId = $selectedUser->id;
        $res = new reservation();
        $res->addReservation($_POST["datetime"], $_POST["pc"], $selectedUserId, $session->userid);
        unset($res);
        header("Location:index.php#reservations");
    } catch (Exception $e) {
        logAction("Kreiranje rezervacije - error", "userid = $session->userid --- $e", 'error.txt');
    }
}

$defDate = new DateTime();
$formatDate = $defDate->format("Y-m-d");
$date = $defDate->format("Y-m-d");
$time = $defDate->format("H:i");
$now = $date . "T" . $time;

// korak u paginaciji
$step = 15;


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
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
                                        <div class="news-item-detail"><a href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title" target="_blank"><?php echo $item->tittle; ?></a>
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


                    <?php
                    include $tableBonusHours;

                    include $tableCompetitionByHero; ?>

                </div>


                <div class="span6">
                    <?php


                    include $tableReservations;

                    include $tableCredits;
                    ?>



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
<?php
include $footerMenuLayout;
?>

</body>
</html>
