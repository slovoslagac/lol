<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

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


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;


if (isset($_POST["save_shift"])) {
    $userid = $session->userid;
    $tmpShift = new shift();
    $currentShift = $tmpShift->getCurrentShift();
    if ($currentShift != '') {
    } else {
        $tmpShift->startShift($userid);
        $newShift = $tmpShift->getCurrentShift();
        $bill = new bill();
        $chekingLastBill = $bill->getLastBill(1, 2);
        $chekingLastBillTime = strtotime($chekingLastBill->tstamp);
        ($chekingLastBillTime != "") ?   : $chekingLastBillTime = 0;
        $now = time();
        if ($now - $chekingLastBillTime > 5) {
            $bill->addBill($session->userid, '', 0, 'normal', 2);
            $tmplastbill = $bill->getLastBill(1, 2);
            logAction("Shfit start section created", "userid = $userid ; billid = $tmplastbill->id", 'shiftDetails.txt');
            $tmpsb = new shiftbill();
            logAction("Shfit & bill connection created", "shiftid = $newShift->id ; billid = $tmplastbill->id", 'shiftDetails.txt');
            $tmpsb->addshiftbill($newShift->id, $tmplastbill->id);
            $tmpShiftDiff = '';
            $tmpShiftDiffArray = array();
            foreach ($allproductids as $id) {
                $diff = $_POST['diff'.$id];
                $curr = $_POST[$id];
                if($diff != 0) { $tmpShiftDiff = $tmpShiftDiff. "$id = $diff ; "; $tmpShiftDiffArray[$id] = $diff;} else { };
                    $tmpbillrow = new billrows();
                    $tmpbillrow->addBillRow($tmplastbill->id, $curr, $productpricesid[$id], $productprices[$id], $id, 0);
                    unset($tmpbillrow);

            }
            if(!empty($tmpShiftDiffArray)) {
                $bill->addBill($session->userid, '', 0, 'normal', 4);
                $tmplastbillnew = $bill->getLastBill(1, 4);
                foreach($allproductids as $id) {
                    if(array_key_exists($id,$tmpShiftDiffArray) ){
                        $billrownew = new billrows();
                        $billrownew->addBillRow($tmplastbillnew->id, $tmpShiftDiffArray[$id], $productpricesid[$id], $productprices[$id], $id, 0  );
                    }

                }
            }


            logAction("Shfit start possible difference", "$tmpShiftDiff", 'shiftDetails.txt');
        }
        redirectTo("kasa.php");
    }

}

//Komentar 3.11.2017 izbrisati za metar dana ako ne pukne nigde :)
//if (isset($_POST["save_shift"])) {
//
//    redirectTo("pazar.php");
//}

if (isset($_POST["kasa"])) {
    $tmparray = array();
    foreach($allsellproducts as $item){

        echo $_POST['diff'.$item->id]."<br>";
        if($_POST['diff'.$item->id] != 0  ) {
            array_push($tmparray, array('num' => $_POST['diff'.$item->id], "id" => $item->id, "type" => 0));
        }
    }

//    var_dump($tmparray);
    $_SESSION['details'] = $tmparray;
    $_SESSION['billstatus'] = -1000;
    $_SESSION['page'] = 'pazar.php';

    redirectTo("kasa.php");
}



?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-time"></i>
                            <h3>Unesi podatke za početak smene</h3>
                        </div>
                        <!-- /widget-header -->
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="widget-content">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="center"> Artikal</th>
                                        <th class="center"> Količina</th>
                                        <th class="center"> Trenutno</th>
                                        <th class="center"> Artikal</th>
                                        <th class="center"> Količina</th>
                                        <th class="center"> Trenutno</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php $total = count($allsellproducts);
                                    $halftotal = round($total / 2, 0, PHP_ROUND_HALF_UP);
                                    $k = 0;
                                    while ($k < $halftotal) {
                                        $item = $allsellproducts[$k];
                                        $numofitems = (array_key_exists($item->productid, $currentvalues)) ? $currentvalues[$item->productid] : "0" ?>
                                        <tr>
                                        <td><?php echo $item->name ?></td>
                                        <td class="center" width="80"><input type="number" name="<?php echo "$item->id" ?>" id="<?php echo "$item->id" ?>" value="<?php echo $numofitems ?>" onchange="currentVal(<?php echo $item->id ?>)" required></td>
                                        <input type="hidden" name="diff<?php echo "$item->id" ?>" id="diff<?php echo "$item->id" ?>" value="0">
                                        <td class="trenutno" id="current<?php echo "$item->id" ?>"><?php echo $numofitems ?></td>
                                        <?php if ($k + $halftotal < $total) {$item = $allsellproducts[$k + $halftotal]; $numofitems = (array_key_exists($item->productid, $currentvalues)) ? $currentvalues[$item->productid] : "0"; ?>
                                            <td><?php echo $item->name ?></td>
                                            <td class="center" width="80"><input type="number" name="<?php echo "$item->id" ?>" id="<?php echo "$item->id" ?>" value="<?php echo $numofitems ?>" onchange="currentVal(<?php echo $item->id ?>)" required></td>
                                            <input type="hidden" name="diff<?php echo "$item->id" ?>" id="diff<?php echo "$item->id" ?>" value="0">
                                            <td class="trenutno" id="current<?php echo "$item->id" ?>"><?php echo $numofitems ?></td>
                                        <?php } else { ?>
                                            <td colspan="3"></td>
                                            </tr>
                                        <?php }
                                        $k++;
                                    } ?>

                                    </tbody>
                                </table>

                            </div>
                            <button type="submit" class="btn btn-large btn-primary btn-right" name="modalbutton" id="modalbutton" data-toggle="modal" href="#status" style="display: none;">Sačuvaj</button>
                            <button type="submit" class="btn btn-large btn-primary btn-right" name="save_shift" id="save_shift" >Sačuvaj</button>


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


<div id="status" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Trenutna neslaganja</h3>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered" >
            <colgroup>
                <col width="50%">
                <col width="50%">
            </colgroup>
            <thead>
            </thead>
            <tbody>
            <colgroup>
                <col width="50%">
                <col width="50%">
            </colgroup>
            <?php foreach ($allsellproducts as $item) { ?>
                <tr id="modal<?php echo $item->id ?>" style="display: none;" width="100%">
                    <td><?php echo $item->name ?></td>
                    <td id="modaldiff<?php echo "$item->id" ?>"></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
        <button class="btn btn-primary" type="submit"  name="save_shift"  >Snimi</button>
    </div>
    </form>
</div>
<!-- /main -->
<!-- Le javascript
================================================== -->
<?php
include $footerMenuLayout;
?>
<script>
    var tmp = [];

    function currentVal(val) {
        var index = tmp.indexOf(val);
        var itemno = val;
        var selectedVal = document.getElementById(itemno).value;
        var currentVal = parseInt(document.getElementById('current' + itemno).innerText);
        var diffVal = document.getElementById('diff' + itemno).value;

        var newdiffVal = currentVal - selectedVal;
        document.getElementById('diff' + itemno).setAttribute("value", newdiffVal);
        document.getElementById('modaldiff' + itemno).setAttribute("value", newdiffVal);
        document.getElementById('modaldiff' + itemno).innerText = newdiffVal;



        if(newdiffVal == 0){
            document.getElementById('modal' + itemno).style.display = 'none';
            if (index > -1) {tmp.splice(index, 1)}
        } else {
            document.getElementById('modal' + itemno).style.display = 'block';
            tmp.push(val);
        }


        console.log(tmp, tmp.length);

        if(tmp.length > 0) {
            document.getElementById('save_shift').style.display = 'none';
            document.getElementById('modalbutton').style.display = 'block';
        } else {
            document.getElementById('modalbutton').style.display = 'none';
            document.getElementById('save_shift').style.display = 'block';
        }
    }



</script>

</body>
</html>
