<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;

$sellproduct = new sellingproduct();
$allProductsRegular = $sellproduct->getAllSellingProducts('normal');
$allProductsPopust = $sellproduct->getAllSellingProducts('popust');

?>

<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix">
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
                <div class="product-round" id="product<?php echo $item->id?>" onclick="add_product('<?php echo $item->id.'__'.$item->value.'__'.$item->name?>');">
                    <label><?php echo $item->name?></label>
                    <img src="img/products/cc03.png">
                    <p id="price<?php echo $item->id?>"><?php echo $item->value .' Din'?></p>

                </div>

            <?php } ?>


        </div> <!-- /content -->

    </div> <!-- /account-container -->
    <div class="bill">
        <div class="bill-header">
            Račun #23
            <span>Stefan</span>
        </div>
        <div class="bill-date">30.03.2017. <span>15:19</span></div>
        <input type="search" placeholder="Anonymus" list="allusers" id="selectuser" onchange="recalculate()">
        <datalist id="allusers">
            <option value="popust">Carevi</option>
            <option value="normal">Kraljevi</option>
        </datalist>
        <div id="billBody">
        </div>
        <div class="bill-discount">POPUST <span>230 Din</span></div>
        <div class="bill-sum" name="bill-sum" id="bill-sum">UKUPNO<span>0 Din</span></div>
        <button class="button btn btn-primary btn-large pay">Plati</button>

    </div>
    <div class="bill">
        <div class="bill-header">
            Prethodna 3 računa
        </div>
        <div class="bills3">
            Račun #22
            <span>1.370 Din</span>
        </div>
        <div class="bills3">
            Račun #21
            <span>990 Din</span>
        </div>
        <div class="bills3">
            Račun #20
            <span>100 Din</span>
        </div>
    </div>
</div>

<?php
include $footerMenuLayout;
?>

<script>
    var product = 0;
    var productsID = [];
    var productsPositions = [];
    var position = '';
    var checkSum = 0;
    var popust = 0;
    function add_product(val) {
        var allval = val.split("__");
        var code = allval[0];
        var price = allval[1];
        var articlename = allval[2];
        checkSum = checkSum + parseInt(price);
        if (productsID.indexOf(code) > -1) {
            position = productsPositions.indexOf(code);

        }
        else {

            productsID.push(code);
            productsPositions[product] = code;
            var objTo = document.getElementById('billBody')
            var divadd = document.createElement("div");
            divadd.setAttribute("id", "product" + product);
            divadd.innerHTML = '<div class="bill-row" name="bill-row' + product + '" val="1"><strong>' + articlename + '</strong><span id="price' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus"></i><i class="icon-minus"></i></div></div>';
            objTo.appendChild(divadd)
            product++;
        }
//        console.log(productsID);
//        console.log(productsPositions);
//        console.log(productsPositions.indexOf(code));
        console.log(checkSum);
        document.getElementById("bill-sum").innerHTML = 'UKUPNO<span>' + checkSum + ' Din</span>';
    }


    var pricesNormal = [<?php foreach($allProductsRegular as $item) { echo "{id: $item->id , name: '$item->name' , price: $item->value}," ;}?>];
    var pricesPopust = [<?php foreach($allProductsPopust as $item) { echo "{id: $item->id , name: '$item->name' , price: $item->value}," ;}?>];
    console.log(pricesPopust);


    function recalculate() {
        var val = document.getElementById('selectuser').value;
        console.log(val);
        var length = 0;
        if (val == 'popust') {
            length = $(pricesPopust).toArray().length;
            for (var $i = 0; $i < length; $i++) {
                var object = pricesPopust[$i];
                console.log(object.price);
                document.getElementById('price' + object.id).innerText = String(object.price) + ' Din';

            }
        } else if (val == 'normal') {
            length = $(pricesNormal).toArray().length;
            for (var $j = 0; $j < length; $j++) {
                var objectnormal = pricesNormal[$j];
                console.log(objectnormal.price);
                document.getElementById('price' + objectnormal.id).innerText = String(objectnormal.price) + ' Din';

            }
        }
//        else {
//            for (var $i = 0; $i < length; $i++) {
//                var object = prices[$i];
//                console.log(object.price);
//                document.getElementById('product' + object.id).innerText = String(object.price);
//
//            }
//
//        }

        console.log(length);
//        console.log(prices[1]);
    }

</script>


</body>

</html>
