<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

$date = new DateTime();

$smartlaunh = 1000;

$userid = $currentWorker->id;
$tmpShift = new shift();
$currentShift = $tmpShift->getCurrentShift();
$lastid = $currentShift->id;

$alldata = getMoneyFlow($lastid);


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

var_dump($allproductids);

$currentvalues = array();
$allStocks = getstockstatus();
foreach ($allStocks as $item) {
    $currentvalues[$item->productid] = $item->amount - $item->sale_amount;
}
echo "<br>";
var_dump($allStocks);

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

            foreach ($allproductids as $id) {
                $numofitems = (array_key_exists($id, $currentvalues)) ? $currentvalues[$id] : "0";
                    $tmpbillrow = new billrows();
                    $tmpbillrow->addBillRow($tmplastbill->id, $numofitems, $productpricesid[$id], $productprices[$id], $id, 0);
                    unset($tmpbillrow);

            }

        }


        $tmpShift->endShift($userid, $shiftId);
        redirectTo("kasa.php");
    }

}

?>
<!-- /subnavbar -->
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3><?php echo date_format($date, 'd.m.Y') . " - $currentWorker->name - Pazar" ?></h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
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
                                        <td><input type="number" id="money" name="money" value="0" placeholder="<?php echo number_format(2000, 2, ',', '.') . 'Din' ?>" class="pazar"
                                                   onchange="calculatevalue()"/></td>
                                    </tr>
                                    <tr>
                                        <td>Depozit</td>
                                        <td id="deposit" name="deposit" value="">2.000 Din</td>
                                    </tr>
                                    <tr>
                                        <td>Novac bez depozita</td>
                                        <td id="depositeless"></td>
                                    </tr>
                                    <tr>
                                        <td>Kompjuteri</td>
                                        <td><?php echo number_format($smartlaunh, 0, ',', '.') ?> Din</td>
                                        <input type="hidden" id="smartlaunch" name="smartlaunch" value="<?php echo $smartlaunh ?>"
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
                                        <td><input type="number" id="otherdata" name="otherdata" value="0" placeholder="Ostali troškovi" class="pazar" onchange="calculatevalue()"/></td>
                                    </tr>
                                    <tr>
                                        <td> Ukupno predato novca</td>
                                        <td id="finalsum"></td>
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
                                        <textarea placeholder="Upisati objašnjenje ukoliko se pazar ne poklapa sa stanjem iz Smartlauncha" class="textarea"></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <button type="submit" class="btn btn-large btn-danger btn-right" name="save_shift" id="save_shift">Kraj smene i logout <i class="btn-icon-only icon-chevron-right"> </i></button>
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
        var sumdata = parseInt(document.getElementById('sum').value);
        var sumcomp = parseInt(document.getElementById('smartlaunch').value);
        var sumother = parseInt(document.getElementById('otherdata').value);
        var cashmoney = parseInt(document.getElementById('money').value);
        var deposit = parseInt(2000);
        console.log(sumdata, sumcomp, sumother);
        var finalsum = (sumcomp + sumdata + deposit - sumother);


        document.getElementById('finalsum').innerText = (finalsum.toLocaleString('de-DE') + ' Din');

        console.log(finalsum);


        if (cashmoney > 0) {
            var tmpsum = cashmoney - deposit;
            document.getElementById('depositeless').innerText = (tmpsum.toLocaleString('de-DE') + ' Din');
        }
    }

    calculatevalue();
</script>
</body>
</html>
