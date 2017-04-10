<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 1.4.2017
 * Time: 14:02
 */




?>


<!-- Wrapper -->
<div id="wrapper">

    <div class="bonus_hours">

        <div class="bonus_header">OSVOJENI BONUS SATI ZA <?php echo monthName($month) ?> 2017.</div>

        <div class="bonus_column">

            <?php $i = 1;
            foreach ($allBonusesCurrentMonth as $item) {
            $user = $item->Username;
            $hour = $item->this_month;

            $rest = fmod($i, 20.1);
            if ($rest < 1) { ?>
        </div>
        <div class="bonus_column" value="<?php echo $rest; ?>">
            <?php
            }
            ?>
            <div class="bonus_row">
                <div class="bonus_rb"><?php echo $i ?></div>
                <div class="bonus_name"><?php echo substr($user,0,15) ?></div>
                <div class="bonus_time"><?php echo $hour ?></div>
                <div class="bonus_prize"><?php echo countBonus($hour) ?></div>
            </div>


            <?php $i++;
            } ?>
        </div>
    </div>
    <div class="bonus_footer">
        <div class="bonus_logo"></div>
    </div>

</div>



