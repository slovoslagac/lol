<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmptype = new producttypes();
$allProductTypes = $tmptype->getAllProductTypes();

$tmpproduct = new products();
$allProducts = $tmpproduct->getAllProducts();
$maxArticles = 5;
$arlticleList = array();

if (isset($_POST["addArticle"])) {
    $newName = $_POST["productName"];
    $newId = $_POST["producttype"];
    settype($newId, "integer");
    $newArticle = new products($newName, $newId);
    $newArticle->addNewProduct();
    unset($newArticle);
    header("Location:unos_artikala.php");
}

if(isset($_POST["createArticle"])){
    for($j=1; $j<= $maxArticles; $j++){
        if($_POST["item$j"] != ''){
            $arlticleList[$_POST['item'.$j]] = $_POST['item'.$j.'quantity'] ;
        }
    }

    print_r($arlticleList);
}

$currentpage = 'magacin.php';
include $menuLayout;
?>

<div class="span9 pull-left">
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
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
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
        <?php foreach ($allProducts as $item) {
            echo "<strong>$item->producttype</strong> : $item->productname <br>";


        } ?>

    </div>

</div> <!-- /account-container -->
<div class="span9">
    <div class="order-container register">
        <div class="content clearfix">
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

                <h2>Kreiraj novi artikal za prodaju</h2>
                <div
                ">
                <div class="span12">
                    <input type="text" name="name" placeholder="Naziv" required>
                </div>
                <div class="span12">
                    <input type="number" step="0.01" name="price" placeholder="Cena" required>
                    <input type="number" step="0.01" name="discount_price" placeholder="Cena sa popustom" required>
                </div>
                <br>
                <div class="span4">
                    <?php for ($i = 1; $i <= $maxArticles; $i++) { ?>

                        <select name="item<?php echo $i ?>">
                            <option value=""></option>
                            <?php foreach ($allProducts as $item) { ?>
                                <option value="<?php echo $item->id ?>"><?php echo "$item->productname ($item->producttype)" ?></option>
                            <?php } ?>
                        </select>

                        <input type="number" name="item<?php echo $i ?>quantity" value="1">
                        <?php
                    } ?>
                </div>
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
