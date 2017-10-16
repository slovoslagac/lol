<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentDate = new dateTime();
$currentMonth = $currentDate->format('d.m.Y');
$currentTime = $currentDate->format('H:i');


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

$sellproduct = new sellingproduct();
$allProductsRegular = $sellproduct->getAllSellingProductsByType('normal');
$allProductsPopust = $sellproduct->getAllSellingProductsByType('popust');
$allProducts = $sellproduct->getAllSellingProducts();
$bill = new bill();
$lastBill = $bill->getLastBill();
$tmpBillsDetails = $bill->getLastBillsByUserDetails(3, $session->userid);



if ($lastBill != '') {
    $maxBillID = $lastBill->id + 1;
} else {
    $maxBillID = 1;
}
$data = array();


if (isset($_POST['payment'])) {
    $sumBillError = $_POST['billSum'];
    if ($sumBillError > 0 ) {
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
                    if (isset($_POST['na' . $item->id])) {
                        $tmpbillrow = new billrows();
                        $tmpbillrow->addBillRow($tmpid, $_POST['na' . $item->id], $item->sppid, $item->value, $item->id);
                        unset($tmpbillrow);
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
    if ($sumBillError > 0 ) {
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
                    if (isset($_POST['na' . $item->id])) {

                        $tmpbillrow->addBillRow($billIdForEdit, $_POST['na' . $item->id], $item->sppid, $item->value, $item->id);

                    }
                }
                unset($tmpbillrow);
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

if(isset($_POST["paymentDelete"])){
    $billIdForDelete =  $_POST["billId"];
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
            <?php $tmptype = '';
            foreach ($allProductsRegular as $item) {
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
                <div class="product-round" id="product<?php echo $item->id ?>" onmousedown="articles(event, '<?php echo $item->id ?>');">

                    <label id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></label>
                    <?php $filename = str_replace(' ', '-', $item->name);  $path = 'img/products/' ; if(file_exists($path.$filename.'.png') == 1) {} else {$filename = "default";} ; ?>

                    <img src="<?php echo $path.$filename?>.png">
                    <p id="price<?php echo $item->id ?>"><?php echo $item->value . ' Din' ?></p>

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
        <input type="text" name="selectuser" placeholder="Anonymus" list="allusers" id="selectuser" oninput="recalculate()">
        <datalist id="allusers">
            <option value="damir@kokeza.com - popust"></option>
            <option value="dado@gmail.com - normal"></option>
        </datalist>
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
                        echo "]},";
                    };
                    $tmpbilldetailid = $item->billid;
                    ($item->username != '') ? $type = $item->username . ' - ' . $item->pricetype : $type = '';
                    echo "{id: $item->billid, type: '$type', billdata:[{num: $item->amount, id: $item->productid},";
                } else {
                    echo "{num: $item->amount, id: $item->productid},";
                }

            }
            echo ($tmpbilldetailid > 0) ?  "]}" : "";


        ?>];


    var product = 0;
    var productsID = [];
    var position = '';
    var popust = 0;


    function articles(event, val) {
        if (event.button == 0) {
            add_product(val);
        } else if (event.button == 2) {
            removeArticle(val);
        }
    }

    function add_product(val) {
        var code = val;
        var price = parseInt(document.getElementById('price' + code).innerText);
        var articlename = document.getElementById('articlename' + code).innerText;
        if (productsID.indexOf(code) > -1) {
            addArticle(code);
        }
        else {
            productsID.push(code);
            var objTo = document.getElementById('billBody');
            var divadd = document.createElement("div");
            divadd.setAttribute("id", "checkproduct" + code);
            divadd.innerHTML = '<div class="bill-row" id="article' + code + '" ><input type="hidden" name="na' + code + '" id="na' + code + '" value="1"><strong id="numarticle' + code + '">1</strong></input><strong> x ' + articlename + '</strong><span id="checkprice' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus" onclick="addArticle(' + code + ')"></i><i class="icon-minus" onclick="removeArticle(' + code + ')"></i></div></div>';
            objTo.appendChild(divadd)
            product++;
        }
        calculateSum();
    }


    function addArticle(val) {
        var currVal = parseInt(document.getElementById('numarticle' + val).innerText);
        currVal++;
        document.getElementById('numarticle' + val).innerText = String(currVal);
        document.getElementById('na' + val).setAttribute("value", currVal);
        calculateSum();
    }

    function removeArticle(val) {
        var currVal = parseInt(document.getElementById('numarticle' + val).innerText);
        currVal--;
        if (currVal == 0) {
            document.getElementById('checkproduct' + val).remove();
            productsID.splice(productsID.indexOf(String(val)), 1);
            product--;
        }
        else {
            document.getElementById('numarticle' + val).innerText = String(currVal);
            document.getElementById('na' + val).setAttribute("value", currVal);
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
        document.getElementById('sum').innerText = String(Sum) + ' Din';
        document.getElementById('billSum').setAttribute("value", String(Sum));
        var normalAmount = testSumCalculation();

        document.getElementById('discount').innerText = String(normalAmount - Sum) + ' Din';
    }


    function testSumCalculation() {
        var tmpSum = 0;
        var la = $(pricesNormal).toArray().length;
        for (var k = 0; k < la; k++) {
            var tmpobject = pricesNormal[k];
            var tmpindex = productsID.indexOf(String(tmpobject.id));
            if (tmpindex > -1) {
                var numArt = parseInt(document.getElementById('numarticle' + tmpobject.id).innerText);
                var priceArt = parseInt(tmpobject.price);
                tmpSum = tmpSum + numArt * priceArt;
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

        document.getElementById("payment").setAttribute("class", "hide");
        document.getElementById("paymentEdit").setAttribute("class", "button btn btn-primary btn-large pay");
        document.getElementById("paymentCancel").setAttribute("class", "button btn btn-primary btn-small pay");
        document.getElementById("paymentDelete").setAttribute("class", "button btn btn-primary btn-small pay");


        for (var l = 0; l < 3; l++) {
            var billobject = billDetails[l];
            if (billobject.id == val) {
                document.getElementById("selectuser").value = billobject.type;
                document.getElementById("billId").setAttribute("value",  billobject.id);
                document.getElementById("billNumber").innerText =  billobject.id;
                var tmpDetails = billobject.billdata;
                for (var p = 0; p < tmpDetails.length; p++) {
                    var tmpproduct = tmpDetails[p];
                    var tmpproductid = tmpproduct.id.toString();
                    add_product(tmpproductid);
                    if (tmpproduct.num > 1) {
                        var s = 1;
                        while (s < tmpproduct.num) {
                            addArticle(tmpproductid)
                            s++
                        }
                    }
                }
            }
        }
        recalculate()

    }

    function resetBill() {
        for(var t =0; t < productsID.length; t++){
            var val = productsID[t];
            document.getElementById('checkproduct' + val).remove();
        }
        productsID =[];
    }




</script>

<script>
    function disableButton(val) {
        document.getElementById(val).disabled = true;
    }
</script>


</body>

</html>
