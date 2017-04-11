<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage =  basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>

<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix">
            <h3>Piće</h3>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>
            </div>
            <h3>Grickalice</h3>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
            <div class="product-round">
                <label>Coca Cola 0,3</label>
                <img src="img/products/cc03.png">
                <p>90 Din</p>

            </div>
        </div> <!-- /content -->

    </div> <!-- /account-container -->
    <div class="bill">
        <div class="bill-header">
        Račun #23
        <span>Stefan</span>    
        </div>
        <div class="bill-date">30.03.2017. <span>15:19</span></div>
        <input type="search" placeholder="Anonymus">
        <div class="bill-row">
            1x <strong>Coca Cola 0,3</strong>
            <span>90 Din</span>
            <div class="plusminus"><i class="icon-plus"></i><i class="icon-minus"></i></div>
        </div>
        <div class="bill-row">
            1x <strong>Coca Cola 0,3</strong>
            <span>90 Din</span>
            <div class="plusminus"><i class="icon-plus"></i><i class="icon-minus"></i></div>
        </div>
        <div class="bill-row">
            1x <strong>Coca Cola 0,3</strong>
            <span>90 Din</span>
            <div class="plusminus"><i class="icon-plus"></i><i class="icon-minus"></i></div>
        </div>
        <div class="bill-row">
            1x <strong>Coca Cola 0,3</strong>
            <span>90 Din</span>
            <div class="plusminus"><i class="icon-plus"></i><i class="icon-minus"></i></div>
        </div>
        <div class="bill-row">
            1x <strong>Coca Cola 0,3</strong>
            <span>90 Din</span>
            <div class="plusminus"><i class="icon-plus"></i><i class="icon-minus"></i></div>
        </div>
        <div class="bill-discount">POPUST <span>230 Din</span></div>
        <div class="bill-sum">UKUPNO<span>1.370 Din</span></div>
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
</body>

 </html>
