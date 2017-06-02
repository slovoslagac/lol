<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmptype = new producttypes();
$allProductTypes = $tmptype->getAllProductTypes();

$tmpproduct = new products();
$allProducts = $tmpproduct->getAllProducts();
$maxArticles = 5;
$articleList = array();
$articleQuantities = array();

if (isset($_POST["addArticle"])) {
    $newName = $_POST["productName"];
    $newId = $_POST["producttype"];
    settype($newId, "integer");
    $newArticle = new products($newName, $newId);
    $newArticle->addNewProduct();
    unset($newArticle);
    header("Location:unos_artikala.php");
}

if (isset($_POST["createArticle"])) {
    for ($j = 1; $j <= $maxArticles; $j++) {
        if ($_POST["item$j"] != '') {
            array_push($articleList, $_POST["item$j"]);
            $articleQuantities[$_POST['item' . $j]] = $_POST['item' . $j . 'quantity'];
        }
    }

    if (count($articleList) > 0) {
        $selingArticleDetail = new spDetails();
        try {
            $currentTime = round(microtime(true) * 1000);
            $currentName = $_POST["name"];
            $currentType = $_POST["articleType"];
            $normalPrice = $_POST["price"];
            $discountPrice = $_POST["discount_price"];
            $currentProduct = new sellingproduct($currentName, $currentType);
            $currentProduct->addNewSellingProduct();
            $newSellingProduct = $currentProduct->getSellingProductByName();
            $articleId = $newSellingProduct->id;
            $tmpPrice = new spPrice();
            $tmpPrice->addselingproductprice($articleId, $normalPrice, 'normal');
            $tmpPrice->addselingproductprice($articleId, $discountPrice, 'popust');
        } catch (Exception $e) {
            logAction("Dodavanje novih artikala za prodaju cene i artikal - error", "userid = $session->userid --- $e | $currentName - $currentType - $normalPrice - $discountPrice", 'error.txt');
        }

        try {
            foreach($articleList as $article){
                $selingArticleDetail->addSPdetail($articleQuantities[$article],$article, $articleId);
            }
        } catch (Exception $e) {
            logAction("Dodavanje novih artikala detalji - error", "userid = $session->userid --- $e | $articleList \n $articleQuantities", 'error.txt');
        }

    }
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
                    <input type="text" name="name" placeholder="Naziv" required autofocus>
                    <select class="span2" name="articleType">
                        <?php
                        foreach ($allProductTypes as $item) {
                            ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="span12">
                    <input type="number" step="0.01" name="price" placeholder="Cena" required>
                    <input type="number" step="0.01" name="discount_price" placeholder="Cena sa popustom" required>
                </div>
                <br>

                <div class="span6">
                    <?php for ($i = 1; $i <= $maxArticles; $i++) { ?>

                        <select name="item<?php echo $i ?>" class="span3">
                            <option value=""></option>
                            <?php foreach ($allProducts as $item) { ?>
                                <option value="<?php echo $item->id ?>"><?php echo "$item->productname" ?></option>
                            <?php } ?>
                        </select>

                        <input class="span1" type="number" name="item<?php echo $i ?>quantity" value="1">
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
