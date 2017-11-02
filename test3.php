<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

include $menuLayout;
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" xmlns="http://www.w3.org/1999/html"/>
<div class="register-round">

    <div class="cash-register register">

        <div class="cash-content clearfix" oncontextmenu="return false">
            <h3>Playstation</h3>

            <a class="sony sony_active" id="test1">
                <input type="hidden" value="2" id="numplayers1">
                <div class="iiplayers plactive" id="2player1"><img src="img/playstation/2players.png" onclick="changeplayernum(2, 1)"></div>
                <div class="ivplayers" id="4player1"><img src="img/playstation/4players.png" onclick="changeplayernum(4, 1)"></div>
                <img src="img/playstation/ps1.png"  onclick="checkresponse(1)">
                <label id="sony1">Test 1</label>

            </a>
            <a class="sony sony_active" id="test2" style="display: none">
                <input type="hidden" value="2" id="numplayers2">
                <div class="iiplayers plactive" id="2player2"><img src="img/playstation/2players.png" onclick="changeplayernum(2, 2)"></div>
                <div class="ivplayers" id="4player2"><img src="img/playstation/4players.png" onclick="changeplayernum(4, 2)"></div>
                <img src="img/playstation/ps1.png"  onclick="checkresponse(2)">
                <label id="sony1">Test 2</label>

            </a>
        </div>
    </div>
</div>

<?php
include $footerMenuLayout;
?>

<script>




    function change(val){

        if(val == '2') {
            document.getElementById('test1').style.display="block";
            document.getElementById('test2').style.display="none";

        } else if (val == '1'){
            document.getElementById('test1').style.display="none";
            document.getElementById('test2').style.display="block";
        }
    }

    function changeplayernum(val, num) {
        document.getElementById("numplayers" + num).setAttribute("value", val);
        if (val == 2) {
            document.getElementById('2player' + num).setAttribute("class", "iiplayers plactive");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers");
        } else {
            document.getElementById('2player' + num).setAttribute("class", "iiplayers");
            document.getElementById('4player' + num).setAttribute("class", "ivplayers plactive");

        }

    }

    function checkresponse(val) {
        var numplayer = document.getElementById('numplayers'+val).value;
        if (confirm("Press a button!") == true) {
            change(val);
            console.log(numplayer);
        } else {

        }

    }
</script>

</body>

</html>
