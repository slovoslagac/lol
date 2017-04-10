<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 1.4.2017
 * Time: 14:02
 */

$currentDate = new dateTime();
//var_dump($currentDate);
$currentMonth = $currentDate->format('n');

//kad se bude menjalo promeniti i u js da ne bi blesavilo switcovanje izmedju meseca.
$month = $currentMonth - 1;


$bonus = new bonus;
$allBonusesCurrentMonth = $bonus->getResults($month);



//Obracun za tekuci mesec

//$countItemsCurr = '';
//foreach ($allBonusesCurrentMonth as $item) {
//    if ($item->this_month > 0) {
//        $countItemsCurr++;
//    }
//}

?>

<div id="CurrentMonthTable" class="">

        <div class="widget-content">
            <table class="table table-striped table-bordered">

                <!-- Wrapper -->
                <div id="wrapper">

                    <div class="bonus_hours">

                        <div class="bonus_header">OSVOJENI BONUS SATI ZA MART 2017.</div>

                        <div class="bonus_column">
                            <?php $i = 1;
                            foreach ($allBonusesCurrentMonth as $item) {
                            $user = $item->Username;
                            $hour = $item->this_month; ?>
                            <div class="bonus_row">
                                <div class="bonus_rb"><?php echo $i ?></div>
                                <div class="bonus_name"><?php echo $user ?></div>
                                <div class="bonus_time"><?php echo $hour ?></div>
                                <div class="bonus_prize"><?php echo countBonus($hour) ?></div>
                            </div>
                            <?php $i++;  }?>
                        </div>
                    </div>
                    <div class="bonus_footer">
                        <div class="bonus_logo"></div>
                    </div>

                </div>

        </div>
    </div>
</div>

