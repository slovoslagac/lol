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
    $currmaxAmount = $usr->getMaxAmountByUser($user);
    ($currmaxAmount == '') ? $tmpMaxAmount = 1000 : $tmpMaxAmount = $currmaxAmount->sum;
    $tmpAmount = $_POST["amountChosen"];
    if ($user != '' && $tmpAmount <= $tmpMaxAmount) {
        try {
            $usr->addUserCredit($user, $tmpAmount, $session->userid);
            unset($usr);
            header("Location:index.php#credits");
        } catch (Exception $e) {
            logAction("Dodavanje dugova - error", "userid = $session->userid --- $e | user - $user, adding credit - $tmpAmount, maximum amount - $tmpMaxAmount ", 'error.txt');
        }
    } else {

        echo "<script type='text/javascript'>if(alert('Korisnik maksimalno moze da se zaduzi jos $tmpMaxAmount dinara!')){window.location.reload();}</script>";
//        header("Location:index.php#credits");
        logAction("Dodavanje dugova - error - ne proslazi user ili max amount", "worker - $session->userid, user - $user, adding credit - $tmpAmount, maximum amount - $tmpMaxAmount", 'error.txt');
    }

}


if (isset($_POST['reduceCredit'])) {

    $reducedCredit = abs($_POST['amountDebit']) * -1;
    $currentuser = $_POST['currentUserId'];
    $currmaxAmount = $usr->getMaxAmountByUser($currentuser);
    ($currmaxAmount == '') ? $tmpMaxAmount = 0 : $tmpMaxAmount = $currmaxAmount->currentSum;
    if (abs($_POST['amountDebit']) <= $tmpMaxAmount) {
        try {
            $usr->addUserCredit($currentuser, $reducedCredit, $session->userid);
            $currusrcredit = $usr->getSumUserCredit($currentuser);
            if ($currusrcredit->value == 0) {
                $usr->creditExpire($currentuser);
            }
            unset($usr, $currusrcredit);
            header("Location:index.php#credits");
        } catch (Exception $e) {
            logAction("Smanjivanje dugova - error", "$currentuser, $reducedCredit, $session->userid  | worker - $session->userid, user - $currentuser, adding credit - $reducedCredit, maximum amount - $tmpMaxAmount, error - $e", 'error.txt');
        }
    } else {
        ($tmpMaxAmount > 0) ? $message = "Korisnik treba da vrati najvise $tmpMaxAmount dinara! " : $message = "Korisnik nema dugovanja !";

        echo "<script type='text/javascript'>if(alert('$message')){window.location.reload();}</script>";
        logAction("Dodavanje dugova - error - pokusavaju da vrate vise nego sto duguje", "worker - $session->userid, user - $currentuser, adding credit - $reducedCredit, maximum amount - $tmpMaxAmount", 'error.txt');
    }


//    } catch (Exception $e) {
//        logAction("Brisanje dugova - error", "userid = $session->userid --- $e", 'error.txt');
//    }


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
        $cmpArray = array();
        foreach ($_POST['cmp'] as $cmp) {
            array_push($cmpArray, $cmp);
        }
        $currentCmpArray = implode(',', $cmpArray);
        $selectedUser = $u->getUserByUsername($_POST["user"]);
        $selectedUserId = $selectedUser->id;
        $res = new reservation();
        $res->addReservation($_POST["datetime"], $currentCmpArray, $selectedUserId, $session->userid);
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
                                $allInfo = $info->getAllInformations(0, 4);
                                foreach ($allInfo as $item) { ?>
                                    <li>
                                        <div class="news-item-date">
                                            <span class="news-item-day"><?php echo $item->tmpdate; ?></span> <span class="news-item-month"><?php echo $item->month; ?></span>
                                        </div>
                                        <div class="news-item-detail">
                                            <a href="#" class="news-item-title" target="_blank"><?php echo $item->tittle; ?></a>
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
//                    include $tableBonusHours;

//                    $tableType = 2;
//                    include $tableCompetitionByUser; ?>

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
