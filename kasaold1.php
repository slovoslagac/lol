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

if(isset($_SESSION['details'])) {
    $newBillDetaill = $_SESSION['details'];
    $billstatus = $_SESSION['billstatus'];
    unset($_SESSION['details']);
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
                $bill->addBill($session->userid, $discountuserid, $billSum, $pricetype);
                $tmplastbill = $bill->getLastBill();
                $tmpid = $tmplastbill->id;
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
                                $slackmessage = "Uplaceno je $item->name na  # $j u ukupnom trajanju od - $sonyval min/puta na racunu broj $tmpid";
                                logAction("Dodavanje sonija", "Uplaceno je $item->name na sony # $j u ukupnom trajanju od - $sonyval veza racun broj $tmpid", 'slack.txt');
                                sendSlackInfo($slackmessage, $financialChanel);
                            }
                            unset($tmpbillrow);
                        }
                    }
                }
            } catch (Exception $e) {
                logAction("Kucanje racuna - error", "suma - $sumBillError, details - $session->userid, addBill - $session->userid, $discountuserid, $billSum, $pricetype", 'error.txt');
            }

            unset($discountuserid, $billSum, $pricetype);
            header("Location:$currentpage");
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
                                $slackmessage = "Promenjeno je  $item->name na  # $j u ukupnom trajanju od - $sonyval min/puta na racunu broj $billIdForEdit";
                                logAction("Dodavanje sonija", "Uplaceno je $item->name na sony # $j u ukupnom trajanju od - $sonyval veza racun broj $billIdForEdit", 'slack.txt');
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" xmlns="http://www.w3.org/1999/html"/>
<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix" oncontextmenu="return false">
            <h3>Playstation</h3>
            <?php for ($i = 1; $i <= $numSony; $i++) {
                $sonyTime = new DateTime($sonyDetails[$i]);
                ($sonyTime > $currentDate) ? $diff = date_diff($sonyTime, $currentDate) : $diff = null;
                ($diff != null) ? $sonydiff = $diff->h * 60 + $diff->i : $sonydiff = 0; ?>
                <div class="<?php echo ($sonydiff > 0) ? ($sonydiff > 15) ? "sony sony_active" : "sony sony_soon" : "sony sony_free" ?>" id="sony<?php echo $i ?>status">
                    <input type="hidden" value="2" id="numplayers">
                    <div class="iiplayers plactive" id="2player<?php echo $i ?>"><img src="img/playstation/2players.png" onclick="changeplayernum(2, <?php echo $i ?>)"></div>
                    <div class="ivplayers" id="4player<?php echo $i ?>"><img src="img/playstation/4players.png" onclick="changeplayernum(4, <?php echo $i ?>)"></div>
                    <img src="img/playstation/ps<?php echo $i ?>.png">
                    <label id="sony<?php echo $i; ?>">&nbsp</label>
                    <?php foreach ($allProductsSony as $item) {
                        if (strpos($item->name, '2') and (strpos($item->name, '3h')) === false) {
                            ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>

                            <div id="2playersbox<?php echo $i ?>">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 15, <?php echo $i ?>);">+15</p>
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 60, <?php echo $i ?>);">+1h</p>
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
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 15, <?php echo $i ?>);">+15</p>
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 60, <?php echo $i ?>);">+1h</p>
                            </div>
                            <?php
                        } elseif (strpos($item->name, '4') and (strpos($item->name, '3h'))) { ?>
                            <div hidden id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></div>
                            <p id="price<?php echo $item->id ?>" hidden><?php echo $item->value . ' Din' ?></p>

                            <div id="4playersboxbonus<?php echo $i ?>" style="display: none">
                                <p id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>', 1, <?php echo $i ?>);">+3h</p>
                            </div>
                            <?php
                        }

                    } ?>
                </div>
            <?php }

            $tmptype = '';
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


        </div> <!-- /content -->

    </div> <!-- /account-container -->
    <div class="bill">
        <div class="bill-header">
            Račun #<strong id="billNumber"><?php echo $maxBillID; ?></strong><input type="hidden" name="billId" id="billId"/>
            <span><?php echo "$currentWorker->name $currentWorker->lastname" ?></span>
        </div>
        <div class="bill-date"><?php echo $currentMonth ?><span><?php echo $currentTime ?></span></div>
        <input type="text" name="selectuser" placeholder="Anonymus" list="allusers" id="selectuser" oninput="recalculate()">
        <!--        <datalist id="allusers">-->
        <!--            <option value="damir@kokeza.com - popust"></option>-->
        <!--            <option value="dado@gmail.com - normal"></option>-->
        <!--        </datalist>-->
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
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(id).innerHTML = "slobodan";
                document.getElementById(classid).setAttribute("class", "sony sony_free");
            } else if (distance < 900000) {
                document.getElementById(classid).setAttribute("class", "sony sony_soon");
            } else {
                document.getElementById(classid).setAttribute("class", "sony sony_active");

            }
        }, 1000);
    }
    var tmplength = $(sonydetails).toArray().length;
    for (var j = 1; j <= 4; j++) {
        var tmpcd = null;
        var cd = null;
        for (var p = 0; p < tmplength; p++) {
            var tmpobject = sonydetails[p];
            if (tmpobject.id == j) {
                var cd = tmpobject.date;

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


    var product = 0;
    var productsID = [];
    var position = '';
    var popust = 0;


    function articles(event, val, amount, type) {
        if (event.button == 0) {
            add_product(val, amount, type);
        } else if (event.button == 2) {
            add_product(val, 0, type);
            removeArticle(val, amount, type);
        }
    }

    function add_product(val, amount, type) {
        var code = val + '_' + type;
        var price = parseInt(document.getElementById('price' + val).innerText);
        var articlename = document.getElementById('articlename' + val).innerText;
        if (productsID.indexOf(code) > -1) {
            addArticle(val, amount, type);
        }
        else {
            productsID.push(code);
            var objTo = document.getElementById('billBody');
            var divadd = document.createElement("div");
            divadd.setAttribute("id", "checkproduct" + code);
            if (type == 0) {
                divadd.innerHTML = '<div class="bill-row" id="article' + code + '" ><input type="hidden" name="na' + code + '" id="na' + code + '" value="' + amount + '"><input type="hidden" name = "type' + code + '" id = "type' + code + '" value="' + type + '"><strong id="numarticle' + code + '">' + amount + '</strong></input><strong> x ' + articlename + '</strong><span id="checkprice' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus" onclick="addArticle(' + val + ', 1, ' + type + ')"></i><i class="icon-minus" onclick="removeArticle(' + val + ', 1, ' + type + ')"></i></div></div>';
            } else {
                divadd.innerHTML = '<div class="bill-row" id="article' + code + '" ><input type="hidden" name="na' + code + '" id="na' + code + '" value="' + amount + '"><input type="hidden" name = "type' + code + '" id = "type' + code + '" value="' + type + '"><strong id="numarticle' + code + '">' + amount + '</strong></input><strong> x (#' + type + ') ' + articlename + '</strong><span id="checkprice' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus" onclick="addArticle(' + val + ', 1, ' + type + ')"></i><i class="icon-minus" onclick="removeArticle(' + val + ', 1, ' + type + ')"></i></div></div>';
            }
            objTo.appendChild(divadd)
            product = product + amount;
        }
        calculateSum();
    }


    function addArticle(val, amount, type) {
        var code = val + '_' + type;
        var currVal = parseInt(document.getElementById('numarticle' + code).innerText);
        currVal = currVal + amount;
        document.getElementById('numarticle' + code).innerText = String(currVal);
        document.getElementById('na' + code).setAttribute("value", String(currVal));
        calculateSum();
    }

    function removeArticle(val, amount, type) {
        var code = val + '_' + type;
        var currVal = parseInt(document.getElementById('numarticle' + code).innerText);
        currVal = currVal - amount;
        if (currVal <= <?php echo $billstatus ?>) {
            document.getElementById('checkproduct' + code).remove();
            productsID.splice(productsID.indexOf(String(val)), 1);
            product--;
        }
        else {
            document.getElementById('numarticle' + code).innerText = String(currVal);
            document.getElementById('na' + code).setAttribute("value", currVal);
        }
        calculateSum();
    }


    function calculateSum() {
        var Sum = 0;
        var lengthArray = $(productsID).toArray().length;
        if (lengthArray > 0) {
            for (var k = 0; k < lengthArray; k++) {
                var articleId = productsID[k];
                var numArt = parseInt(document.getElementById('numarticle' + articleId).innerText);
                var priceArt = parseInt(document.getElementById('checkprice' + articleId).innerText);
                Sum = Sum + numArt * priceArt;
            }
        }
        var hourval = parseInt(document.getElementById("hours").value);
        if (hourval > 0) {
            hourval = hourval
        } else {
            hourval = 0
        }
        ;
        tmpSum = Sum + hourval;
        document.getElementById('sum').innerText = String(tmpSum) + ' Din';
        document.getElementById('billSum').setAttribute("value", String(Sum));
        var normalAmount = testSumCalculation();

        document.getElementById('discount').innerText = String(normalAmount - Sum) + ' Din';
    }


    function testSumCalculation() {
        var tmpSum = 0;
        var la = $(pricesNormal).toArray().length;
        for (var k = 0; k < la; k++) {
            var tmpobject = pricesNormal[k];
            for (var j = 0; j < 5; j++) {
                var tmpindex = productsID.indexOf(String(tmpobject.id + '_' + j));
                if (tmpindex > -1) {
                    var numArt = parseInt(document.getElementById('numarticle' + tmpobject.id + '_' + j).innerText);
                    var priceArt = parseInt(tmpobject.price);
                    tmpSum = tmpSum + numArt * priceArt;
                }
            }
        }
        return tmpSum;
    }


    function recalculate() {
        var val = document.getElementById('selectuser').value.split(' - ')[1];
        var length = 0;
        if (val == 'popust') {
            length = $(pricesPopust).toArray().length;
            for (var i = 0; i < length; i++) {
                var object = pricesPopust[i];
                var id = object.id;
                var price = object.price;
                document.getElementById('price' + id).innerText = String(price) + ' Din';
                if (document.getElementById('checkprice' + id) !== null) {
                    document.getElementById('checkprice' + id).innerText = String(price);
                }

            }
        } else if (val == 'normal') {
            length = $(pricesNormal).toArray().length;
            for (var j = 0; j < length; j++) {
                var objectnormal = pricesNormal[j];
                var idnorm = objectnormal.id;
                var pricenorm = objectnormal.price;
                document.getElementById('price' + idnorm).innerText = String(pricenorm) + ' Din';
                if (document.getElementById('checkprice' + idnorm) !== null) {
                    document.getElementById('checkprice' + idnorm).innerText = String(pricenorm);
                }
            }
        } else {
            length = $(pricesNormal).toArray().length;
            for (var j = 0; j < length; j++) {
                var objectnormal = pricesNormal[j];
                var idnorm = objectnormal.id;
                var pricenorm = objectnormal.price;
                document.getElementById('price' + idnorm).innerText = String(pricenorm) + ' Din';
                if (document.getElementById('checkprice' + idnorm) !== null) {
                    document.getElementById('checkprice' + idnorm).innerText = String(pricenorm);
                }
            }
        }
        calculateSum();
    }


    function editBill(val) {

        resetBill();
        console.log(billDetails);


        document.getElementById("payment").setAttribute("class", "hide");
        document.getElementById("paymentEdit").setAttribute("class", "button btn btn-primary btn-large pay");
        document.getElementById("paymentCancel").setAttribute("class", "button btn btn-primary btn-small pay");
        document.getElementById("paymentDelete").setAttribute("class", "button btn btn-primary btn-small pay");

        for (var l = 0; l < 3; l++) {
            var billobject = billDetails[l];
            if (billobject.id == val) {
                document.getElementById("selectuser").value = billobject.type;
                document.getElementById("billId").setAttribute("value", billobject.id);
                document.getElementById("billNumber").innerText = billobject.id;
                deletestatus = billobject.deletestatus;
                console.log(deletestatus, billobject.deletestatus);
                var tmpDetails = billobject.billdata;
                for (var p = 0; p < tmpDetails.length; p++) {
                    var tmpproduct = tmpDetails[p];
                    var tmpproductid = tmpproduct.id.toString();
                    var tmpproducttype = tmpproduct.typepr;
                    add_product(tmpproductid, tmpproduct.num, tmpproducttype);

                }
            }
        }

        console.log(deletestatus);


        if (deletestatus == '1') {
            document.getElementById("paymentDelete").style.display = 'none';
        } else if (deletestatus == '0') {
            document.getElementById("paymentDelete").style.display = 'block';
        }

        recalculate()

    }

    function resetBill() {
        for (var t = 0; t < productsID.length; t++) {
            var val = productsID[t];
            document.getElementById('checkproduct' + val).remove();
        }
        productsID = [];
    }


</script>

<script>
    function disableButton(val) {
        document.getElementById(val).disabled = true;
    }
</script>


<script>
    function changeplayernum(val, num) {
        document.getElementById("numplayers").setAttribute("value", val);
        if (val == 2) {
            document.getElementById('2playersbox' + num).style.display = 'block';
            document.getElementById('2playersboxbonus' + num).style.display = 'block';
            document.getElementById('4playersbox' + num).style.display = 'none';
            document.getElementById('4playersboxbonus' + num).style.display = 'none';
            document.getElementById('2player' + num).setAttribute("class", "iiplayers plactive");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers");
        } else {
            document.getElementById('2playersbox' + num).style.display = 'none';
            document.getElementById('2playersboxbonus' + num).style.display = 'none';
            document.getElementById('4playersbox' + num).style.display = 'block';
            document.getElementById('4playersboxbonus' + num).style.display = 'block';
            document.getElementById('2player' + num).setAttribute("class", "iiplayers");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers plactive");

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
    console.log(numofarticals);
    if (numofarticals > 0) {
        for (var k = 0; k < numofarticals; k++) {
            var tmpproduct = newbillDetails[k];
            add_product(tmpproduct.id, tmpproduct.num, tmpproduct.typepr);
        }
    }
</script>

</body>

</html>
