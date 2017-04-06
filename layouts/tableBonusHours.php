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
$allBonusesPreviousMonth = $bonus->getResults($month - 1);
$bonusHoursCurrentMonth = $bonus->getMonthlyBonus($month - 1);
$bonusHoursPreviousMonth = $bonus->getMonthlyBonus($month - 2);


//Obracun za tekuci mesec

$countItemsCurr = '';
foreach ($allBonusesCurrentMonth as $item) {
    if ($item->this_month > 0) {
        $countItemsCurr++;
    }
}
$numPagesCurr = ceil($countItemsCurr / $step);


//Obracun za prethodni mesec

$countItemsPrev = '';
foreach ($allBonusesPreviousMonth as $item) {
    if ($item->this_month > 0) {
        $countItemsPrev++;
    }
}
$numPagesPrev = ceil($countItemsPrev / $step);


$tableId = 'BonusHours';
$tableIdOld = 'BonusHoursOld';
$page = 1;

?>
<input type="hidden" id="currentMonth" value="<?php echo $month ?>">
<div id="CurrentMonthTable" class="">
    <div class="widget widget-table action-table">

        <div class="widget-header"><i class="icon-time"></i>
            <h3>Bonus sati tekući mesec
                <input type="hidden" id="<?php echo $tableId ?>" value="1"/>
                <?php if ($numPagesCurr > 1) { ?>
                    <a href="#back" id="<?php echo $tableId ?>left">
                        <i class="icon-chevron-left" onclick="leftRight('1__<?php echo $tableId . '__' . $numPagesCurr . '__' . $step . '__' . $countItemsCurr ?>')"></i>
                    </a>
                    <span class="center" id="<?php echo $tableId ?>PageNum"><?php echo "$page / $numPagesCurr" ?></span>
                    <a href="#next" id="<?php echo $tableId ?>right">
                        <i class="icon-chevron-right" onclick="leftRight('2__<?php echo $tableId . '__' . $numPagesCurr . '__' . $step . '__' . $countItemsCurr ?>')"></i>
                    </a>
                <?php } ?>

            </h3>
            <div class="controls">
                <a href="#CurrentMonthTable" class="btn" id="<?php echo $tableId ?>switchMonth"
                   onclick="switchMonth('0__<?php echo $tableIdOld . '__' . $numPagesPrev . '__' . $step . '__' . $countItemsPrev ?>')">Prethodni mesec</a>

            </div>
        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="20"> RB</th>
                    <th> Username</th>
                    <th width="40"> Br. Sati</th>
                    <th width="40"> Bonus Sati</th>
                    <th width="40"> Bonus</th>
                    <th width="40"> Očekivano</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($allBonusesCurrentMonth as $item) {
                    $user = $item->Username;
                    $hour = $item->this_month; ?>
                    <tr id="<?php echo "$tableId$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                        <td class="center"><?php echo $i ?></td>
                        <td><?php echo $user ?></td>
                        <td class="center"><?php echo $hour ?></td>
                        <td class="center"><?php echo (isset($bonusHoursCurrentMonth[$item->id])) ? $bonusHoursCurrentMonth[$item->id] : "" ?></td>
                        <td class="center"><?php echo countBonus($hour) ?></td>
                        <td class="center"> <?php echo nextBonus($hour); ?></td>
                    </tr>

                    <?php $i++;
                }

                $rest = fmod($countItemsCurr, $step);
                $numOfRows = $step - $rest;
                if ($rest > 0) {
                    for ($k = 1; $k <= $numOfRows; $k++) { ?>
                        <tr id="add<?php echo "$tableId$k" ?>" <?php echo ($numPagesCurr > 1) ? "class=\"hide\"" : "" ?>>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>


                    <?php }
                } ?>

                </tbody>

            </table>
        </div>
    </div>
</div>
<div id="PreviousMonthTable" class="hide">
    <div class="widget widget-table action-table">
        <div class="widget-header"><i class="icon-time"></i>
            <h3>Bonus sati prethodni mesec
                <input type="hidden" id="<?php echo $tableIdOld ?>" value="1"/>
                <?php if ($numPagesPrev > 1) { ?>
                    <a href="#back" id="<?php echo $tableIdOld ?>left">
                        <i class="icon-chevron-left" onclick="leftRight('1__<?php echo $tableIdOld . '__' . $numPagesPrev . '__' . $step . '__' . $countItemsPrev ?>')"></i>
                    </a>
                    <span class="center" id="<?php echo $tableIdOld ?>PageNum"><?php echo "$page / $numPagesPrev" ?></span>
                    <a href="#next" id="<?php echo $tableIdOld ?>right">
                        <i class="icon-chevron-right" onclick="leftRight('2__<?php echo $tableIdOld . '__' . $numPagesPrev . '__' . $step . '__' . $countItemsPrev ?>')"></i>
                    </a>
                <?php } ?>

            </h3>
            <div class="controls">
                <a href="#PreviousMonthTable" class="btn" id="<?php echo $tableId ?>switchMonth"
                   onclick="switchMonth('0__<?php echo $tableId . '__' . $numPagesCurr . '__' . $step . '__' . $countItemsCurr ?>')">Tekući mesec</a>

            </div>
        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="20"> RB</th>
                    <th> Username</th>
                    <th width="40"> Br. Sati</th>
                    <th width="40"> Bonus Sati</th>
                    <th width="40"> Bonus</th>
                    <th width="40"> Očekivano</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($allBonusesPreviousMonth as $item) {
                    $user = $item->Username;
                    $hour = $item->this_month; ?>
                    <tr id="<?php echo "$tableIdOld$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                        <td class="center"><?php echo $i ?></td>
                        <td><?php echo $user ?></td>
                        <td class="center"><?php echo $hour ?></td>
                        <td class="center"><?php echo (isset($bonusHoursPreviousMonth[$item->id])) ? $bonusHoursPreviousMonth[$item->id] : "" ?></td>
                        <td class="center"><?php echo countBonus($hour) ?></td>
                        <td class="center">-</td>
                    </tr>

                    <?php $i++;
                }

                $rest = fmod($countItemsPrev, $step);
                $numOfRows = $step - $rest;
                if ($rest > 0) {
                    for ($k = 1; $k <= $numOfRows; $k++) { ?>
                        <tr id="add<?php echo "$tableIdOld$k" ?>" <?php echo ($numPagesPrev > 1) ? "class=\"hide\"" : "" ?>>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>


                    <?php }
                } ?>

                </tbody>

                <script>
                    function switchMonth(val) {
                        var d = new Date();
                        var n = d.getMonth();
                        var cd = parseInt(document.getElementById("currentMonth").value);
                        console.log(cd);
                        if (cd == n) {
                            document.getElementById("currentMonth").setAttribute("value", cd - 1);
                            document.getElementById("PreviousMonthTable").setAttribute("class", "");
                            document.getElementById("CurrentMonthTable").setAttribute("class", "hide");
                            document.getElementById("BonusHours").setAttribute("value", "1");
                            leftRight(val);

                        } else {

                            document.getElementById("currentMonth").setAttribute("value", cd + 1);
                            document.getElementById("PreviousMonthTable").setAttribute("class", "hide");
                            document.getElementById("CurrentMonthTable").setAttribute("class", "");
                            document.getElementById("BonusHoursOld").setAttribute("value", "1");
                            leftRight(val);


                        }
                    }
                </script>
            </table>
        </div>

    </div>
</div>