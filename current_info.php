<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$tmpVal = '';
if(isset($_REQUEST['infoNumber'])) {
    $newInfoValue = $_REQUEST['infoNumber'];
} else {
    $newInfoValue = '';
}

if ($newInfoValue != "") {
    $infoVal = $newInfoValue;
} else {
    $infoVal = $tmpVal;
}

$information = new info();
$currentInformation = $information->getInformationById($infoVal);

$currentpage = 'informacije.php';
include $menuLayout;

if(isset($_POST['deleteInfo'])) {
    $deleteId = $_POST['infoId'];
    $information->deleteInformatioById($deleteId);
    unset($information, $infoVal);
    redirectTo("informacije.php");
}

if(isset($_POST['editInfo'])) {
    $editId = $_POST['infoId'];
    $editDate = $_POST['date'];
    $editTittle = $_POST['tittle'];
    $editText = $_POST['infoText'];
    $information->editInfo($editId,$editDate,$editText,$editTittle);
    unset($information, $infoVal);
    redirectTo("informacije.php");
}

?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row center">
                <?php if ($infoVal >0 ){ ?>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" value="<?php echo $currentInformation->id?>" name="infoId">
                Datum :
                <input type="date" name="date" value="<?php echo $currentInformation->date ?>" required/><br/>
                Naslov:
                <input type="text" name="tittle" placeholder="Naslov" required value="<?php echo $currentInformation->tittle ?>"/><br/>
                Tekst :
                <input type="text" name="infoText" value="<?php echo $currentInformation->text ?>" placeholder="Text vesti" required max="1000" style="width: 500px; height: 200px" autofocus /><br/><br/><br/>
                <input type="submit" class="btn" name="deleteInfo" value="Obriši"/>
                <input class="btn btn-primary" type="submit" name="editInfo" value="Izmeni informaciju"/>

                </form>
                <!-- /span6 -->

                <?php } ?>
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
