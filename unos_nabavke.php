<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$prd = new products();
$allprd = $prd->getAllProducts();
$countprd = count($allprd);

if(isset($_POST["saveDellivery"]) != ''){
    $suplierid = $_POST["selectSupplier"];
    $date = new DateTime();
    $formatDate = $date->format("Y-m-d");
    if ($suplierid > 0) {
        $ord = new orders();
        $ord->addOrder($formatDate,$suplierid,$session->userid);
        $maxOrder = $ord->getMaxId();
        print($maxOrder->id);
        unset($ord,$suplierid);
//        header("Location:unos_nabavke.php");
    }

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

$currentpage = 'magacin.php';
include $menuLayout;
?>
<div class="order-container register">

    <div class="content clearfix">

        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

            <h1>Unos nabavke</h1>

            <select id="selectSupplier" name="selectSupplier" required>
                <option></option>
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


<?php
include $footerMenuLayout;
?>

</body>

</html>
