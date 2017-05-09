<?php
include(join(DIRECTORY_SEPARATOR, array('..', 'includes', 'init.php')));

$result = new result();
$allresults = $result->getSumResult(40);

?>

<!DOCTYPE HTML>
<!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <!--        <meta http-equiv="refresh" content="15;3.php" />-->
    <title>Dimension by HTML5 UP</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="assets/css/ie9.css"/><![endif]-->
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css"/>
    </noscript>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    <div class="lol_competition">

        <div class="lol_header">LOL KLUB</div>
        <div class="lol_column">

            <?php $i = 1;
            foreach ($allresults as $item) {

            $rest = fmod($i, 20.1);
            if ($rest < 1) { ?>
        </div>
        <div class="lol_column" value="<?php echo $rest; ?>">
            <?php
            }
            ?>
            <div class="lol_row">
                <div class="lol_rb"><?php echo $i ?></div>
                <div class="lol_name"><?php echo substr($item->uusername,0,12) ?></div>
                <div class="lol_champion"></div>
                <div class="lol_win"><?php echo $item->value ?></div>
            </div>


            <?php $i++;
            } ?>
        </div>

    </div>
    <div class="bonus_footer">
        <div class="bonus_logo"></div>
    </div>

</div>

<!-- BG -->
<div id="bg2"></div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
