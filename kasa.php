<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>

<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix">
            <h3>Piće</h3>
            <div class="product-round" id="product121" onclick="add_product('121__90__Coca Cola 0,3');">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round" id="product25" onclick="add_product('25__40__Coca Cola 0,5');">
                <label>Coca Cola 0,5</label>
                <img src="img/products/cc03.png">
                <p>40 Din</p>

            </div>
            <div class="product-round" id="product31" onclick="add_product('31__60__Fanta 0,3');">
                <label>Fanta 0,3</label>
                <img src="img/products/cc03.png">
                <p>60 Din</p>

            </div>

            <h3>Grickalice</h3>
            <div class="product-round" id="product14" onclick="add_product('14__75__Sendvič');">
                <label>Sendvič</label>
                <img src="img/products/cc03.png">
                <p>75 Din</p>

            </div>
            <div class="product-round" id="product7" onclick="add_product('7__15__Stapići');">
                <label>Stapići</label>
                <img src="img/products/cc03.png">
                <p>15 Din</p>

            </div>


        </div> <!-- /content -->

    </div> <!-- /account-container -->
    <div class="bill">
        <div class="bill-header">
            Račun #23
            <span>Stefan</span>
        </div>
        <div class="bill-date">30.03.2017. <span>15:19</span></div>
        <input type="search" placeholder="Anonymus" list="allusers" id="selectuser">
        <datalist id="allusers">
            <option onselect="recalculate(1)">Carevi</option>
            <option onselect="recalculate(0)">Kraljevi</option>
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


    var prices = [{id: 14, name: 'DzidzaBidza', price: 13}, {id: 11, name: 'DzidzaBidza', price: 5}];

    document.getElementById('selectuser').addEventListener('input', recalculate(1));

    function recalculate(val) {
        console.log(val);
        var length = $(prices).toArray().length;
        if (val == 1) {
            for (var $i = 0; $i < length; $i++) {
                var object = prices[$i];
                console.log(object.price);
                document.getElementById('product' + object.id).innerText = object.name;

            }
        }
        else {
            for (var $i = 0; $i < length; $i++) {
                var object = prices[$i];
                console.log(object.price);
                document.getElementById('product' + object.id).innerText = String(object.price);

            }

        }

//        console.log(length);
//        console.log(prices[1]);
    }

</script>


</body>

</html>
