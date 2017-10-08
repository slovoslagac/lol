<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$sellproducts = new sellingproduct();
$allsellproducts = $sellproducts->getAllSellingProductsByType('normal');
//var_dump($allsellproducts);
$allproductids = array();
$productprices = array();
$productpricesid = array();
foreach ($allsellproducts as $item) {
    array_push($allproductids, $item->id);
    $productprices[$item->id] = $item->value;
    $productpricesid[$item->id] = $item->sppid;
};

$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;


if (isset($_POST["save_shift"])) {
    $userid = $currentWorker->id;
    $tmpShift = new shift();
    $currentShift = $tmpShift->getCurrentShift();
    if ($currentShift != '') {
        $shiftId = $currentShift->id;

        $bill = new bill();
        $chekingLastBill = $bill->getLastBill(1, 3);
        $chekingLastBillTime = strtotime($chekingLastBill->tstamp);
        ($chekingLastBillTime != "") ? $chekingLastBillTime = $chekingLastBillTime : $chekingLastBillTime = 0;
        $now = time();
        if ($now - $chekingLastBillTime > 5) {
            $bill->addBill($session->userid, '', 0, 'normal', 3);
            $tmplastbill = $bill->getLastBill(1, 3);
            logAction("Shfit end section created", "userid = $userid ; billid = $tmplastbill->id", 'shiftDetails.txt');
            $tmpsb = new shiftbill();
            logAction("Shfit & bill connection created", "shiftid = $shiftId ; billid = $tmplastbill->id", 'shiftDetails.txt');
            $tmpsb->addshiftbill($shiftId, $tmplastbill->id);
            foreach ($allproductids as $id) {
                if ($_POST[$id] > 0) {
                    $tmpbillrow = new billrows();
                    $tmpbillrow->addBillRow($tmplastbill->id, $_POST[$id], $productpricesid[$id], $productprices[$id], $id);
                    unset($tmpbillrow);
                }
            }


        }


        $tmpShift->endShift($userid, $shiftId);
        redirectTo("index.php");
    }
    foreach ($allproductids as $id) {
    }
}


?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3>Unesi podatke za kraj smene</h3>
                        </div>
                        <!-- /widget-header -->
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="widget-content">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="center"> Artikal</th>
                                        <th class="center"> Količina</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($allsellproducts as $item) { ?>
                                        <tr>
                                            <td><?php echo $item->name ?></td>
                                            <td class="center" width="80"><input type="number" name="<?php echo "$item->id" ?>" required></td>

                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <button type="submit" class="btn btn-large btn-primary btn-right" name="save_shift" id="save_shift">Sačuvaj</button>
                        </form>

                    </div>


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
<?php
include $footerMenuLayout;
?>
</body>
</html>
