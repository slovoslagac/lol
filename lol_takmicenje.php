<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$step = 30;

$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span6">

                    <?php include $tableCompetitionByUser; ?>
                </div>


                <div class="span6">
                    <?php include $tableCompetitionByHero; ?>
                </div>
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
