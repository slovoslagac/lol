<?php
include(join(DIRECTORY_SEPARATOR, array('..', 'includes', 'init.php')));

$user = new user();
$topusers = $user->getAllUsersByRank();

?>

<!DOCTYPE HTML>
<!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Dimension by HTML5 UP</title>
    <!--        <meta http-equiv="refresh" content="15;1.php" />-->
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

    <div class="ranks_competition">

        <div class="ranks_header">LOL KLUB - Rankovi</div>

        <div class="ranks_column">

            <?php $i = 1;
            foreach ($topusers as $item) {

            $rest = fmod($i, 10.1);
            if ($rest < 1) { ?>
        </div>
        <div class="ranks_column" value="<?php echo $rest; ?>">
            <?php
            }
            ?>
            <div class="ranks_row">
                <div class="ranks_rb"><?php echo $i ?></div>
                <div class="ranks_name"><?php echo substr($item->arenausername,0,12) ?></div>
                <div class="ranks_lane <?php echo $item->positionname?>"><img src="images/<?php echo $item->positionname?>.png"></div>
                <div class="ranks_rank"><?php echo $item->rankname ?></div>
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
<div id="bg3"></div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
