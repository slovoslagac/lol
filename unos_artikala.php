<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmptype = new producttypes();
$allProductTypes = $tmptype->getAllProductTypes();

$tmpproduct = new products();
$allProducts = $tmpproduct->getAllProducts();


if(isset($_POST["addArticle"])){
    $newName = $_POST["productName"];
    $newId = $_POST["producttype"];
    settype($newId, "integer");
    $newArticle = new products($newName, $newId);
    $newArticle->addNewProduct();
    unset($newArticle);
    header("Location:unos_artikala.php");
}

$currentpage = 'magacin.php';
include $menuLayout;
?>

<div class="span6 pull-left">
    <div class="order-container register">


        <div class="content clearfix">

            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

                <h2>Unesi novi artikal za nabavku</h2>
                <div>
                    <input type="text" name="productName">
                    <select name="producttype">
                    <?php
                    foreach ($allProductTypes as $item) {
                        ?>
                            <option value="<?php echo $item->id?>"><?php echo $item->name?></option>
                        <?php
                    }
                    ?>
                    </select>
                    <button class="button btn btn-primary btn-large" type="submit" name="addArticle">Sačuvaj artikal</button>

                </div> <!-- .actions -->

            </form>

        </div> <!-- /content -->

    </div>
    <div class="order-container register">
        <?php foreach($allProducts as $item) {
            echo "<strong>$item->producttype</strong> : $item->productname <br>";


        }?>

    </div>

</div> <!-- /account-container -->
<div class="span6">
    <div class="order-container register">


        <div class="content clearfix">

            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

                <h2>Kreiraj novi artikal za prodaju</h2>
                <div>
                    <input type="text" name="name">

                    <button class="button btn btn-primary btn-large" type="submit" name="createArticle">Kreiraj artikal</button>

                </div> <!-- .actions -->

            </form>

        </div> <!-- /content -->

    </div>

</div> <!-- /account-container -->


<?php
include $footerMenuLayout;
?>

</body>

</html>
