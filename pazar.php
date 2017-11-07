<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

$date = new DateTime();


$userid = $currentWorker->id;
$tmpShift = new shift();
$currentShift = $tmpShift->getCurrentShift();
$lastid = $currentShift->id;

$billid = $tmpShift->billidofcurrentShift($lastid);


$alldata = getMoneyFlow($billid->billid);


$sellproducts = new sellingproduct();
$allsellproducts = $sellproducts->getAllSellingProductsByPriceTypeCheckSum('normal');
$allproductids = array();
$productprices = array();
$productpricesid = array();
foreach ($allsellproducts as $item) {
    array_push($allproductids, $item->id);
    $productprices[$item->id] = $item->value;
    $productpricesid[$item->id] = $item->sppid;
};


$currentvalues = array();
$allStocks = getstockstatus();
foreach ($allStocks as $item) {
    $currentvalues[$item->productid] = $item->amount - $item->sale_amount;
}
echo "<br>";


$sellproducts = new sellingproduct();
$allsellproducts = $sellproducts->getAllSellingProductsByPriceTypeCheckSum('normal');
//var_dump($allsellproducts);
$allproductids = array();
$productprices = array();
$productpricesid = array();
foreach ($allsellproducts as $item) {
    array_push($allproductids, $item->id);
    $productprices[$item->id] = $item->value;
    $productpricesid[$item->id] = $item->sppid;
};

$currentvalues = array();
$allStocks = getstockstatus();
foreach ($allStocks as $item) {
    $currentvalues[$item->productid] = $item->amount - $item->sale_amount;
}

if (isset($_POST["save_shift"])) {
    $userid = $currentWorker->id;
    $tmpShift = new shift();
    $currentShift = $tmpShift->getCurrentShift();
    if ($currentShift != '') {
        $shiftId = $currentShift->id;

        $bill = new bill();
        $chekingLastBill = $bill->getLastBill(1, 3);
        $chekingLastBillTime = strtotime($chekingLastBill->tstamp);

        $now = time();
        if ($now - $chekingLastBillTime > 5) {
            $bill->addBill($session->userid, '', 0, 'normal', 3);
            $tmplastbill = $bill->getLastBill(1, 3);
            logAction("Shfit end section created", "userid = $userid ; billid = $tmplastbill->id", 'shiftDetails.txt');
            $tmpsb = new shiftbill();
            logAction("Shfit & bill connection created", "shiftid = $shiftId ; billid = $tmplastbill->id", 'shiftDetails.txt');
            $tmpsb->addshiftbill($shiftId, $tmplastbill->id);

//            $safe = $_POST['money'] || 0;
            $deposit = $_POST['deposit'];
            $computers = $_POST['smartlaunch'];
            $costs = $_POST['otherdata'];
            $moneysum = $_POST['fs'];
            $comment = $_POST['comment'];
            $wage = $_POST['wage'];
            $safe = $moneysum + $deposit + $wage;
//            $bill->addBillDetails($tmplastbill->id, $safe, $deposit, $computers, $costs, $moneysum, $comment);
            $bill->addBillSum($tmplastbill->id, $safe, $deposit, $computers, $costs, $moneysum, $wage);
            foreach ($allsellproducts as $item) {
                $id = $item->id;
                $numofitems = (array_key_exists($item->productid, $currentvalues)) ? $currentvalues[$item->productid] : "0";
                $tmpbillrow = new billrows();
                $tmpbillrow->addBillRow($tmplastbill->id, $numofitems, $productpricesid[$id], $productprices[$id], $id, 0);
                unset($tmpbillrow);

            }

        }


        $tmpShift->endShift($userid, $shiftId);
        redirectTo("logout.php");
    }

}

?>
<!-- /subnavbar -->
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span6">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="widget widget-table action-table">
                            <div class="widget-header"><i class="icon-time"></i>
                                <h3><?php echo date_format($date, 'd.m.Y') . " - $currentWorker->name - Pazar" ?></h3>
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="center"> Artikal</th>
                                        <th class="center"> Početno</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> Ukupno novca u kasi</td>
                                        <td id="money" ></td>
                                    </tr>
                                    <tr>
                                        <td>Depozit</td>
                                        <td><input class="pazar" id="deposit" name="deposit" value="2000" onchange="calculatevalue()"/></td>
                                    </tr>
                                    <tr>
                                        <td>Dnevnica</td>
                                        <td><input class="pazar" id="wage" name="wage" value="1000" onchange="calculatevalue()"/></td>
                                    </tr>
                                    <tr>
                                        <td>Kompjuteri</td>
                                        <td><input class="pazar" type="number" id="smartlaunch" name="smartlaunch" value="" onchange="calculatevalue()"/></td>
                                    </tr>
                                    <?php $tmpsum = 0;
                                    foreach ($alldata as $item) {
                                        $tmpsum = $tmpsum + $item->sum; ?>
                                        <tr>
                                            <td><?php echo $item->name ?></td>
                                            <td><?php echo number_format($item->sum, 0, ',', '.') ?> Din</td>
                                        </tr>


                                    <?php } ?>
                                    <input type="hidden" id="sum" name="sum" value="<?php echo $tmpsum ?>">
                                    <tr>
                                        <td> Ostalo</td>
                                        <td><input type="number" id="otherdata" name="otherdata" value="" placeholder="Ostali troškovi" class="pazar" onchange="calculatevalue()"/></td>
                                    </tr>
                                    <tr>
                                        <td> Ukupno predato novca</td>
                                        <td><strong id="finalsum"></strong></td>
                                        <input type="hidden" name="fs" id="fs" value=""/>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div id="diff" style="display: none;"><strong>Razlika</strong></div>
                                        </td>
                                        <td>
                                            <div id="diffval" style="display: none;"></div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>


                </div>
                <!-- /span6 -->
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3>Dodatni komentar</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <td>
                                        <textarea placeholder="Upisati objašnjenje ukoliko se pazar ne poklapa sa stanjem iz Smartlauncha" class="textarea" id="comment" name="comment"></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <button type="submit" class="btn btn-large btn-danger btn-right" name="save_shift" id="save_shift">Kraj smene i logout <i class="btn-icon-only icon-chevron-right"> </i>
                        </button>
                    </div>

                    </form>
                </div>
                <!-- /span6 -->
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

<script>
    function calculatevalue() {
        var sumdata = parseInt(document.getElementById('sum').value)  || 0;
        var sumcomp = parseInt(document.getElementById('smartlaunch').value)  || 0;
        var sumother = parseInt(document.getElementById('otherdata').value)  || 0;
        var deposit = parseInt(document.getElementById('deposit').value)  || 0;
        var wage = parseInt(document.getElementById('wage').value)  || 0;


        var finalsum = sumcomp + sumdata  - sumother - wage || 0;
        var cashmoney = finalsum + deposit + wage;



        document.getElementById('finalsum').innerText = (finalsum.toLocaleString('de-DE') + ' Din');
        document.getElementById('fs').value = finalsum;

        document.getElementById('money').innerText = (cashmoney.toLocaleString('de-DE') + ' Din');

        document.getElementById('comment').required = sumother != 0;

//        if (diff != 0) {
//            document.getElementById('diff').style.display = 'block';
//            document.getElementById('diffval').style.display = 'block';
//
//        } else {
//            document.getElementById('diff').style.display = 'none';
//            document.getElementById('diffval').style.display = 'none';
//        }
    }

    calculatevalue();
</script>
</body>
</html>
