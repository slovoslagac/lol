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


if (isset($_POST['payment'])) {
    $tmpdata = explode(' - ', $_POST['selectuser']);
    echo $tmpdata[1];
    foreach ($allProducts as $item) {
        if (isset($_POST['na' . $item->id])) {
            echo $_POST['na' . $item->id];
        }
    }
}


?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
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
                <div class="product-round" id="product<?php echo $item->id ?>" onclick="add_product('<?php echo $item->id ?>');">
                    <label id="articlename<?php echo $item->id ?>"><?php echo $item->name ?></label>
                    <img src="img/products/cc03.png">
                    <p id="price<?php echo $item->id ?>"><?php echo $item->value . ' Din' ?></p>

                </div>

            <?php } ?>


        </div> <!-- /content -->

    </div> <!-- /account-container -->
    <div class="bill">
        <div class="bill-header">
            Račun #23
            <span><?php echo "$currentWorker->name $currentWorker->lastname" ?></span>
        </div>
        <div class="bill-date"><?php echo $currentMonth ?><span><?php echo $currentTime ?></span></div>
        <input type="text" name="selectuser" placeholder="Anonymus" list="allusers" id="selectuser" oninput="recalculate()">
        <datalist id="allusers">
            <option value="Petar Prodanovic - popust"></option>
            <option value="Marina Sarcevic - normal"></option>
        </datalist>
        <div id="billBody">
        </div>
                <div class="bill-discount">POPUST <span id="discount">0 Din</span></div>
        <div class="bill-sum" name="bill-sum" id="bill-sum">UKUPNO<span id="sum">0 Din</span></div>
        <button class="button btn btn-primary btn-large pay" name="payment" type="submit">Plati</button>

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


    var product = 0;
    var productsID = [];
    var position = '';
    var popust = 0;


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

    function testSumCalculation()  {
        var tmpSum = 0;
        var la =  $(pricesNormal).toArray().length;
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
        var normalAmount = testSumCalculation();

        document.getElementById('discount').innerText = String(normalAmount - Sum) + ' Din';


    }


</script>


</body>

</html>
