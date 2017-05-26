<?php

include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = 'magacin.php';
include $menuLayout;
?>

    <div class="span6 pull-left">
        <div class="order-container register">


            <div class="content clearfix">

                <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

                    <h2>Unesi novi artikal za nabavku</h2>
                    <div>


                        <button class="button btn btn-primary btn-large" type="submit" name="saveArticle">Sačuvaj artikal</button>

                    </div> <!-- .actions -->

                </form>

            </div> <!-- /content -->

        </div>

    </div> <!-- /account-container -->
    <div class="span6">
        <div class="order-container register">


            <div class="content clearfix">

                <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

                    <h2>Kreiraj novi artikal za prodaju</h2>
                    <div>
                        <input type="text" name="name" >

                        <button class="button btn btn-primary btn-large" type="submit" name="saveArticle">Kreiraj artikal</button>

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
