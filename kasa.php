<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentDate = new dateTime();
$currentMonth = $currentDate->format('d.m.Y');
$currentTime = $currentDate->format('H:i');


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

$sellproduct = new sellingproduct();
$allProductsRegular = $sellproduct->getAllSellingProductsByPriceType('normal');
$allProductsPopust = $sellproduct->getAllSellingProductsByPriceType('popust');
$allProducts = $sellproduct->getAllSellingProducts();
$allProductsSony = $sellproduct->getAllSellingProductsByType('normal', $sonyTypeID);
$sonyDetails = getSonyStatus();

$bill = new bill();
$lastBill = $bill->getLastBill();
$tmpBillsDetails = $bill->getLastBillsByUserDetails(3, $session->userid);


$billstatus = 0;
$newBillDetaill = array();


if (isset($_SESSION['details'])) {
    $newBillDetaill = $_SESSION['details'];
    $billstatus = $_SESSION['billstatus'];
    unset($_SESSION['details'], $_SESSION['billstatus']);
}

if ($lastBill != '') {
    $maxBillID = $lastBill->id + 1;
} else {
    $maxBillID = 1;
}

$data = array();


if (isset($_POST['payment'])) {
    $sumBillError = $_POST['billSum'];
    if ($sumBillError != 0) {
        $chekingLastBill = $bill->getLastBill();
        $chekingLastBillTime = strtotime($chekingLastBill->tstamp);
        $now = time();
        if ($now - $chekingLastBillTime > 5) {

            $tmpdata = explode(' - ', $_POST['selectuser']);
            $user = new user();
            $billSum = $sumBillError;
            if ($tmpdata[0] != '') {
                $discountuser = $user->getUserByUsername($tmpdata[0]);
                $discountuserid = $discountuser->id;
                $pricetype = $tmpdata[1];
            } else {
                $discountuserid = 0;
                $pricetype = 'normal';
            }


            try {
                if ($_SESSION['billtype'] != '') {
                    $tmpbilltype = $_SESSION['billtype'];
                    unset($_SESSION['billtype']);
                } else {
                    $tmpbilltype = 1;
                }
                $bill->addBill($session->userid, $discountuserid, $billSum, $pricetype, $tmpbilltype);
                $tmplastbill = $bill->getLastBill(1, $tmpbilltype);


                $tmpid = $tmplastbill->id;
                logAction("Dodavanje racuna ", "$tmpid, $discountuserid, $billSum, $pricetype", 'billTransactions.txt');
                switch ($pricetype) {
                    case 'normal':
                        $data = $allProductsRegular;
                        break;
                    case 'popust';
                        $data = $allProductsPopust;
                        break;
                };
                foreach ($data as $item) {
                    for ($j = 0; $j <= $numSony; $j++) {
                        if (isset($_POST['na' . $item->id . '_' . $j])) {
                            $tmpbillrow = new billrows();
                            $sonyval = $_POST['na' . $item->id . '_' . $j];
                            $tmpbillrow->addBillRow($tmpid, $sonyval, $item->sppid, $item->value, $item->id, $j);

                            if ($item->producttype == $sonyTypeID) {
                                if (strpos($item->name, '3h') !== false) {
                                    $val = $sonyval * 180;

                                } else {
                                    $val = $sonyval * 60;
                                }

                                logAction("Dodavanje sonija", "Uplaceno je $item->name - # $j - $val min, racun broj - $tmpid", 'slack.txt');

                            }
                            unset($tmpbillrow);
                        }
                    }
                }
            } catch (Exception $e) {
                logAction("Kucanje racuna - error", "suma - $sumBillError, details - $session->userid, addBill - $session->userid, $discountuserid, $billSum, $pricetype", 'error.txt');
            }

            unset($discountuserid, $billSum, $pricetype);
            if ($_SESSION['page'] != '') {
                $tmppage = $_SESSION['page'];
                unset($_SESSION['page']);
                logAction("Aditional chek added", "userid = $session->userid; billid = $tmpid", 'shiftDetails.txt');
            } else {
                $tmppage = $currentpage;
            }

            header("Location:$tmppage");

        } else {
            echo "<script type='text/javascript'>alert('Morate sačekati minimum 5 sekundi između 2 uzastopna računa!')</script>";
            logAction("Kucanje racuna - prebrzo kucanje racuna", "suma - $sumBillError, details - $session->userid", 'billTransactions.txt');
        }
    } else {
        logAction("Kucanje racuna -  nema artikala ili je zapocet update racuna a nije zavrsen", "suma - $sumBillError, details - $session->userid", 'billTransactions.txt');
    }
}


if (isset($_POST['paymentEdit'])) {
    $sumBillError = $_POST['billSum'];
    if ($sumBillError > 0) {
        $chekingLastBill = $bill->getLastBill();
        $chekingLastBillTime = strtotime($chekingLastBill->tstamp);
        $now = time();
        if ($now - $chekingLastBillTime > 5) {
            $billIdForEdit = $_POST["billId"];
            $tmpdata = explode(' - ', $_POST['selectuser']);
            $user = new user();
            $billSum = $sumBillError;
            if ($tmpdata[0] != '') {
                $discountuser = $user->getUserByUsername($tmpdata[0]);
                $discountuserid = $discountuser->id;
                $pricetype = $tmpdata[1];
            } else {
                $discountuserid = 0;
                $pricetype = 'normal';
            }

            try {

                $bill->updateBillById($billIdForEdit, $discountuserid, $billSum, $pricetype);
                logAction("Editovanje racuna - edit racuna", "$billIdForEdit, $discountuserid, $billSum, $pricetype", 'billTransactions.txt');
                switch ($pricetype) {
                    case 'normal':
                        $data = $allProductsRegular;
                        break;
                    case 'popust';
                        $data = $allProductsPopust;
                        break;
                };
                $tmpbillrow = new billrows();
                $tmpbillrow->deleteRowsById($billIdForEdit);
                foreach ($data as $item) {
                    for ($j = 0; $j <= $numSony; $j++) {
                        if (isset($_POST['na' . $item->id . '_' . $j])) {
                            $tmpbillrow = new billrows();
                            $sonyval = $_POST['na' . $item->id . '_' . $j];
                            $tmpbillrow->addBillRow($billIdForEdit, $sonyval, $item->sppid, $item->value, $item->id, $j);
                            $tmpval = $_POST['na' . $item->id . '_' . $j];
                            if ($item->producttype == $sonyTypeID) {
                                if (strpos($item->name, '3h') !== false) {
                                    $val = $sonyval * 180;

                                } else {
                                    $val = $sonyval * 60;
                                }
                                $slackmessage = "Izmena racuna $item->name - # $j - $val min, racun broj $billIdForEdit";
                                logAction("Editovanje racuna", "Izmena racuna $item->name - # $j - $val min, racun broj $billIdForEdit", 'slack.txt');
                                sendSlackInfo($slackmessage, $financialChanel);
                            }

                            unset($tmpbillrow);
                        }
                    }
                }

            } catch (Exception $e) {
                logAction("Editovanje racuna - error", "suma - $sumBillError, details - $session->userid, addBill - $session->userid, $discountuserid, $billSum, $pricetype", 'error.txt');
            }

            unset($discountuserid, $billSum, $pricetype);
            header("Location:$currentpage");
        } else {
            echo "<script type='text/javascript'>alert('Morate sačekati minimum 5 sekundi između 2 uzastopna računa!')</script>";
            logAction("Editovanje racuna - prebrzo kucanje racuna", "suma - $sumBillError, details - $session->userid", 'billTransactions.txt');
        }
    } else {
        logAction("Editovanje racuna -  nema artikala ili je zapocet update racuna a nije zavrsen", "suma - $sumBillError, details - $session->userid", 'billTransactions.txt');
    }
}

if (isset($_POST["paymentDelete"])) {
    $billIdForDelete = $_POST["billId"];
    $billRowsDelete = new billrows();
    $billRowsDelete->deleteRowsById($billIdForDelete);
    $bill->deleteBillById($billIdForDelete);
    unset($billIdForDelete, $billIdForDelete);
    header("Location:$currentpage");
}

?>
<form method="post" class="kasa" action="<?php echo $_SERVER['PHP_SELF'] ?>" xmlns="http://www.w3.org/1999/html"/>
<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix" oncontextmenu="return false">

            <?php $tmptype = '';
            foreach ($allProductsRegular as $item) {
                if ($item->producttype != $sonyTypeID) {
                    if ($tmptype != $item->producttype) {
                        $tmptype = $item->producttype;
                        switch ($item->producttype) {
                            case 1:
                                echo "<h3>Hrana</h3>";
                                break;
                            case 2:
                                echo "<h3>Grickalice</h3>";
                                break;
                            case 3:
                                echo "<h3>Piće</h3>";
                                break;
                        }
                    }
                    ?>
                    <div class="product-round" id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, 0);">

                        <label id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></label>
                        <?php $filename = str_replace(' ', '-', $item->name);
                        $path = 'img/products/';
                        if (file_exists($path . $filename . '.png') == 1) {
                        } else {
                            $filename = "default";
                        }; ?>

                        <img src="<?php echo $path . $filename ?>.png">
                        <p id="price<?php echo $item->id ?>"><?php echo $item->value . ' Din' ?></p>

                    </div>

                <?php }
            } ?>


            <h3>Playstation</h3>
            <?php for ($i = 1; $i <= $numSony; $i++) {
                ($sonyDetails[$i] != '') ? $sonyTime = new DateTime($sonyDetails[$i]) : $sonyTime = new DateTime();

                ($sonyTime > $currentDate) ? $diff = date_diff($sonyTime, $currentDate) : $diff = null;
                ($diff != null) ? $sonydiff = $diff->h * 60 + $diff->i : $sonydiff = 0; ?>
                <div class="<?php echo ($sonydiff > 0) ? ($sonydiff > 15) ? "sony sony_active" : "sony sony_soon" : "sony sony_free" ?>" id="sony<?php echo $i ?>status">
                    <input type="hidden" value="2" id="numplayers">
                    <div class="iiplayers plactive" id="2player<?php echo $i ?>"><img src="img/playstation/2players.png" onclick="changeplayernum(2, <?php echo $i ?>)"></div>
                    <div class="ivplayers" id="4player<?php echo $i ?>"><img src="img/playstation/4players.png" onclick="changeplayernum(4, <?php echo $i ?>)"></div>
                    <?php if (in_array($i,$sonyWheelAvailable)) {?><div class="driver" id="driver<?php echo $i ?>"><img src="img/playstation/driver.png" onclick="changeplayernum(3, <?php echo $i ?>)"></div>    <?php }?>
                    <img src="img/playstation/ps<?php echo $i ?>.png">
                    <label id="sony<?php echo $i; ?>">&nbsp</label>
                    <?php foreach ($allProductsSony as $item) {
                        if (strpos($item->name, '2') and (strpos($item->name, '3h')) === false) {
                            ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>

                            <div id="2playersbox<?php echo $i ?>">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 0.25, <?php echo $i ?>);">+15</p>
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+1h</p>
                            </div>
                            <?php
                        } elseif (strpos($item->name, '2') and (strpos($item->name, '3h'))) { ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>

                            <div id="2playersboxbonus<?php echo $i ?>">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+3h</p>
                            </div>
                            <?php
                        } elseif (strpos($item->name, '4') and (strpos($item->name, '3h')) === false) { ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>
                            <div id="4playersbox<?php echo $i ?>" style="display: none">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 0.25, <?php echo $i ?>);">+15</p>
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+1h</p>
                            </div>
                            <?php
                        } elseif (strpos($item->name, '4') and (strpos($item->name, '3h'))) { ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>

                            <div id="4playersboxbonus<?php echo $i ?>" style="display: none">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+3h</p>
                            </div>
                            <?php
                        } elseif (strpos($item->name, 'volan') and (strpos($item->name, '3h')) === false) { ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>
                            <div id="driverbox<?php echo $i ?>" style="display: none">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 0.25, <?php echo $i ?>);">+15</p>
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+1h</p>
                            </div>
                            <?php
                        }elseif (strpos($item->name, 'volan') and (strpos($item->name, '3h'))) { ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>

                            <div id="driverboxbonus<?php echo $i ?>" style="display: none">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+3h</p>
                            </div>
                            <?php
                        }

                    } ?>
                </div>
            <?php } ?>




        </div> <!-- /content -->

    </div> <!-- /account-container -->
    <div class="bill">
        <div class="bill-header">
            Račun #<strong id="billNumber"><?php echo $maxBillID; ?></strong><input type="hidden" name="billId" id="billId"/>
            <span><?php echo "$currentWorker->name $currentWorker->lastname" ?></span>
        </div>
        <div class="bill-date"><?php echo $currentMonth ?><span><?php echo $currentTime ?></span></div>
        <input type="text" name="selectuser" placeholder="Izaberi Coins ukoliko je kupovina za coine" list="allusers" id="selectuser" oninput="recalculate()">
        <datalist id="allusers">
            <option value="Coins - popust"></option>
            <!--<option value="Kasa - normal"></option>-->
        </datalist>
        <div id="billBody">
        </div>
        <div class="bill-sl">Sati<span><input type="number" id="hours" style="width:200px; margin-right:5px;" onchange="calculateSum()">Din</span></div>
        <div id="billBody">
        </div>
        <div class="bill-discount">POPUST <span id="discount">0 Din</span></div>
        <input type="hidden" name="billSum" id="billSum">
        <div class="bill-sum" name="bill-sum" id="bill-sum">UKUPNO<span id="sum">0 Din</span></div>
        <button class="button btn btn-primary btn-large pay" name="payment" id="payment" type="submit">Plati</button>
        <div>
            <button class="hide" name="paymentEdit" id="paymentEdit" type="submit">Sačuvaj</button>
            <button class="hide" name="paymentCancel" id="paymentCancel" type="submit">Otkaži</button>
            <button class="hide" name="paymentDelete" id="paymentDelete" type="submit">Obriši</button>
        </div>
    </div>


    <div class="bill">
        <div class="bill-header">
            Prethodna 3 računa
        </div>
        <?php $last3bills = $bill->getLastBillsByUser(3, $session->userid);
        foreach ($last3bills as $item) {
            ?>
            <div class="bills3" onclick="editBill(<?php echo $item->id ?>)"><a>
                    Račun #<?php echo $item->id ?>
                    <span><?php echo $item->billsum ?> Din</span></a>
            </div>

        <?php } ?>

    </div>
    <div class="bill">
        <div class="bill-header">
            Playstation status
        </div>
        <?php for ($p = 1; $p <= $numSony; $p++) { ?>
            <div class="bills3">
                <a>Playstation #<?php echo $p ?></a><a id="infosony<?php echo $p ?>"></a><span id="timesony<?php echo $p ?>"></span>
            </div>

        <?php } ?>
    </div>
    <div class="bill">
        <div class="bill-header">
            PUBG Jackpot
        </div>
            <div class="bills3">
                2.000 Din<span><a href="">reset</a></span>
            </div>

    </div>
</div>
</div>
</form>
<?php
include $footerMenuLayout;
?>
<script>
    var sonydetails = [
        <?php
        for ($t = 1; $t <= $numSony; $t++) {
            if ($sonyDetails[$t] != null) {
                echo "{ id : $t, date : '$sonyDetails[$t]' } ,";
            }
        } ?>];

    var countDownDate = new Date("Oct 23, 2017 12:25:38").getTime();

    function countdowntimer(id, countDate) {
        // Set the date we're counting down to


        // Update the count down every 1 second
        var x = setInterval(function () {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDate - now;

            // Time calculations for days, hours, minutes and seconds
            var hours = Math.floor(distance / (1000 * 60 * 60));
            if (hours < 10) {
                hours = '0' + hours
            }
            ;
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            if (minutes < 10) {
                minutes = '0' + minutes
            }
            ;
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            if (seconds < 10) {
                seconds = '0' + seconds;
            }
            ;

            // Output the result in an element with id="demo"
            document.getElementById(id).innerHTML = hours + ":" + minutes + ":" + seconds;

            // If the count down is over, write some text
            var classid = id + 'status';
            var sonyinfo = 'info' + id;
            var sonytime = 'time' + id;
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(id).innerHTML = "slobodan";
                document.getElementById(classid).setAttribute("class", "sony sony_free");
                document.getElementById(sonyinfo).innerHTML = " je istekao u ";

            } else if (distance < 900000) {
                document.getElementById(classid).setAttribute("class", "sony sony_soon");
                document.getElementById(sonyinfo).innerHTML = " ističe u ";
            } else {
                document.getElementById(classid).setAttribute("class", "sony sony_active");
                document.getElementById(sonyinfo).innerHTML = " ističe u ";

            }
            if (countDate > 0) {
                var tmpdate = new Date(countDate);
                document.getElementById(sonytime).innerHTML = tmpdate.getDate() + '.' + (tmpdate.getMonth()+1) + '.' + tmpdate.getFullYear() + ' ' + tmpdate.getHours() + ':' + tmpdate.getMinutes();
//                document.getElementById(sonytime).innerHTML = tmpdate.getDate();
            }

        }, 1000);
    }
    var tmplength = $(sonydetails).toArray().length;
    for (var j = 1; j <= 5; j++) {
        var tmpcd = null;
        var cd = null;
        for (var p = 0; p < tmplength; p++) {
            var tmpobject = sonydetails[p];
            if (tmpobject.id == j) {
                cd = tmpobject.date;

            }
        }
        tmpcd = new Date(cd).getTime();

        if (tmpcd != null) {
            countdowntimer('sony' + j, tmpcd);
        }
    }


</script>
<script>


    var pricesNormal = [<?php foreach ($allProductsRegular as $item) {
        echo "{id: $item->id , name: '$item->name' , price: $item->value},";
    }?>];
    var pricesPopust = [<?php foreach ($allProductsPopust as $item) {
        echo "{id: $item->id , name: '$item->name' , price: $item->value},";
    }?>];

    var billDetails = [<?php
        $tmpbilldetailid = 0;

        foreach ($tmpBillsDetails as $item) {
            if ($tmpbilldetailid != $item->billid) {
                if ($tmpbilldetailid > 0) {
                    echo "], deletestatus : $billdeletestatus, },";
                };
                $billdeletestatus = 0;
                $tmpbilldetailid = $item->billid;
                ($item->username != '') ? $type = $item->username . ' - ' . $item->pricetype : $type = '';
                echo "{id: $item->billid, type: '$type', billdata:[{num: $item->amount, id: $item->productid, typepr: $item->type},";
            } else {
                echo "{num: $item->amount, id: $item->productid, typepr: $item->type},";
            }
            if ($item->sptype == $sonyTypeID and $item->timediff > 300) {
                $billdeletestatus = 1;
            }
        }
        echo ($tmpbilldetailid > 0) ? "], deletestatus : $billdeletestatus,}" : "";


        ?>];


</script>

<script>
    var product = 0;
    var productsID = [];
    var position = '';
    var popust = 0;
    var billstatus = <?php echo $billstatus ?>;
    var numSony = <?php echo $numSony?>;


    <?php include('js/kasa.js')?>
</script>

<script>
    function disableButton(val) {
        document.getElementById(val).disabled = true;
    }
</script>


<script>
    function changeplayernum(val, num) {
//        document.getElementById("numplayers").setAttribute("value", val);
        if (val == 2) {
            document.getElementById('2playersbox' + num).style.display = 'block';
            document.getElementById('2playersboxbonus' + num).style.display = 'block';
            document.getElementById('4playersbox' + num).style.display = 'none';
            document.getElementById('4playersboxbonus' + num).style.display = 'none';
            document.getElementById('driverbox' + num).style.display = 'none';
            document.getElementById('driverboxbonus' + num).style.display = 'none';
            document.getElementById('2player' + num).setAttribute("class", "iiplayers plactive");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers");
            document.getElementById('driver' + num).setAttribute("class", "driver");
        } else if(val == 4) {
            document.getElementById('2playersbox' + num).style.display = 'none';
            document.getElementById('2playersboxbonus' + num).style.display = 'none';
            document.getElementById('4playersbox' + num).style.display = 'block';
            document.getElementById('4playersboxbonus' + num).style.display = 'block';
            document.getElementById('driverbox' + num).style.display = 'none';
            document.getElementById('driverboxbonus' + num).style.display = 'none';
            document.getElementById('2player' + num).setAttribute("class", "iiplayers");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers plactive");
            document.getElementById('driver' + num).setAttribute("class", "driver");

        } else if (val == 3){
            document.getElementById('2playersbox' + num).style.display = 'none';
            document.getElementById('2playersboxbonus' + num).style.display = 'none';
            document.getElementById('4playersbox' + num).style.display = 'none';
            document.getElementById('4playersboxbonus' + num).style.display = 'none';
            document.getElementById('driverbox' + num).style.display = 'block';
            document.getElementById('driverboxbonus' + num).style.display = 'block';
            document.getElementById('2player' + num).setAttribute("class", "iiplayers");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers");
            document.getElementById('driver' + num).setAttribute("class", "driver plactive");


        }
    }
</script>


<script>

    var newbillDetails = [<?php
        foreach ($newBillDetaill as $item) {
            $num = $item['num'];
            $id = $item['id'];
            $type = $item['type'];
            echo "{num: $num, id: $id, typepr: $type},";

        }
        ?>];


    var numofarticals = $(newbillDetails).toArray().length;
    if (numofarticals > 0) {
        for (var k = 0; k < numofarticals; k++) {
            var tmpproduct = newbillDetails[k];
            add_product(tmpproduct.id, tmpproduct.num, tmpproduct.typepr);
        }
    }
</script>

</body>

</html>
