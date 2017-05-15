<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));
//
//
//if (!$session->isLoggedIn()) {
//    redirectTo("login.php");
//}
//
//if (isset($_POST["logout"])) {
//    echo "Izlogovali smo se <br>";
//    $session->logout();
//    header("Location:index.php");
//}
//
//$wrk = new worker();
//$currentWorker = $wrk->getWorkerById($session->userid);


if (isset($_POST["saveInfo"])) {
    $newinfo = new info();
    $newinfo->addNewInformation($_POST["date"], $_POST["tittle"], $_POST["infoText"], $session->userid);
    unset($newinfo);
    header("Location:informacije.php");
}

$dateNow = new DateTime();
$dateNow = $dateNow->format("Y-m-d");


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <?php $info = new info();
                    $page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
                    $allInfo = $info->getAllInformations();
                    $perPage = 10;
                    $count = count($allInfo);
                    $pagination = new pagination($page, $count, $perPage);
                    $allInfo = $info->getAllInformations($pagination->offset(), $perPage); ?>


                    <div class="widget widget-nopad">
                        <div class="widget-header"><i class="icon-list-alt"></i>
                            <h3> Važne informacije
                                <?php if ($pagination->hasPreviousPage()) { ?>
                                    <a href="informacije.php?page=<?php echo $pagination->previousPage() ?>" value="<?php echo $pagination->previousPage() ?>" id="leftSide" name="leftSide"><i
                                            class="icon-chevron-left"></i></a>
                                <?php }
                                if ($pagination->hasNextPage()) { ?>
                                    <a href="informacije.php?page=<?php echo $pagination->nextPage() ?>" value="<?php echo $pagination->previousPage() ?>" name="rightSide" id="rightSide"><i
                                            class="icon-chevron-right"></i></a>
                                <?php } ?>
                            </h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="#info" role="button" class="btn" data-toggle="modal">Dodaj novu informaciju</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">

                            <ul class="news-items">

                                <?php
                                foreach ($allInfo as $item) { ?>

                                    <li>

                                        <div class="news-item-date">
                                            <span class="news-item-day"><?php echo $item->tmpdate; ?></span> <span class="news-item-month"><?php echo $item->month; ?></span>
                                        </div>
                                        <div class="news-item-detail">
                                            <a href="#" class="news-item-title" target="_blank"><?php echo $item->tittle; ?></a>
                                            <p class="news-item-preview"><?php echo $item->text; ?></p>
                                        </div>
                                        <form action="current_info.php" method="post">
                                        <input class="text-center btn" type="submit" value="promeni">
                                        <input type="hidden" value="<?php echo $item->id?>" name="infoNumber">
                                        </form>
                                    </li>

                                    <?php
                                }
                                unset($allInfo, $info); ?>

                            </ul>

                        </div>
                        <!-- /widget-content -->

                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <?php $tmpwrk = $wrk->getAdmin();
                            if ($currentWorker->workertypeid == $tmpwrk->id) { ?>

                                <div id="info" class="modal hide fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Unos nove informacije</h3>
                                    </div>
                                    <div class="modal-body">
                                        <input type="date" name="date" value="<?php echo $dateNow ?>" required/><br/>
                                        <input type="text" name="tittle" placeholder="Naslov" required/><br/>
                                        <input type="text" name="infoText" value="" placeholder="Text vesti" required max="1000"/>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                        <button class="btn btn-primary" type="submit" name="saveInfo">Sačuvaj informaciju</button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div id="info" class="modal hide fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h3 id="myModalLabel">Nemate privilegije da dodajete informacije molimo Vas ulogujte se kao administrator</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                                    </div>
                                </div>

                            <?php }
                            unset($tmpwrk); ?>
                        </form>
                    </div>

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
