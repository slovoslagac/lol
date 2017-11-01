<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

include $menuLayout;
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" xmlns="http://www.w3.org/1999/html"/>
<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix" oncontextmenu="return false">
            <h3>Playstation</h3>

            <div class="sony sony_active" onclick="">
                <input type="hidden" value="2" id="numplayers">
                <div class="iiplayers plactive" id="2player1"><img src="img/playstation/2players.png" onclick="changeplayernum(2, <?php echo $i ?>)"></div>
                <div class="ivplayers" id="4player1"><img src="img/playstation/4players.png" onclick="changeplayernum(4, <?php echo $i ?>)"></div>
                <img src="img/playstation/ps1.png">
                <label id="sony1">Test 1</label>

            </div>
            <div class="sony sony_active">
                <input type="hidden" value="2" id="numplayers">
                <div class="iiplayers plactive" id="2player1"><img src="img/playstation/2players.png" onclick="changeplayernum(2, <?php echo $i ?>)"></div>
                <div class="ivplayers" id="4player1"><img src="img/playstation/4players.png" onclick="changeplayernum(4, <?php echo $i ?>)"></div>
                <img src="img/playstation/ps1.png">
                <label id="sony1">Test 2</label>

            </div>
        </div>
    </div>
</div>

<?php
include $footerMenuLayout;
?>


</body>

</html>
