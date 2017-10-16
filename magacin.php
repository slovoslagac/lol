<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$product = new products();
$allProducts = $product->getAllProducts();

$allStocks = getstockstatus();


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">

                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-truck"></i>
                            <h3>Magacin - Mart 2017.</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="unos_artikala.php" role="button" class="btn">Kreiraj artikle</a>
                                <a href="unos_nabavke.php" role="button" class="btn">Dodaj nabavku</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th> Artikal</th>
                                    <th width="100"> Pr. Cijena</th>
                                    <th width="100"> Početak mjeseca</th>
                                    <th width="100"> Nabavka mjesecna</th>
                                    <th width="100"> Prodaja mjesecna</th>
                                    <th width="100"> Trenutna količina</th>
                                    <th width="100"> Prodaja ukupna</th>
                                    <th width="100"> Nabavna cijena</th>
                                    <th width="100"> Zarada</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $tmpsum = 0; foreach ($allStocks as $item) { ?>
                                    <tr>
                                        <td><?php echo $item->name ?></td>
                                        <td class="center"><?php echo ($item->sale_amount != "")? number_format($item->sale_sumprice / $item->sale_amount, 0,',', '.') : 0 ; ?></td>
                                        <td class="center"><?php echo ($item->amount_sm != '') ? $item->amount_sm : 0 ?></td>
                                        <td class="center"><?php echo ($item->amount_cm != '') ? $item->amount_cm : 0 ?></td>
                                        <td class="center"><?php echo ($item->sale_amount_cm != '') ? $item->sale_amount_cm : 0?></td>
                                        <td class="center"><?php echo $item->amount - $item->sale_amount ?></td>
                                        <td class="center"><?php echo ($item->sale_amount != '') ? $item->sale_amount : 0 ?></td>
                                        <td class="center"><?php echo number_format($item->current_price, 2,',', '.') ?></td>
                                        <td class="center"><?php $currentsum = $item->sale_sumprice - $item->sumprice; $tmpsum = $tmpsum + $currentsum; echo number_format($currentsum, 0,',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="8"></td>
                                    <td class="center"><?php echo number_format($tmpsum,0,',', '.')?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /widget -->

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
<!-- Placed at the end of the document so the pages load faster -->
<?php
include $footerMenuLayout;
?>
</body>
</html>
