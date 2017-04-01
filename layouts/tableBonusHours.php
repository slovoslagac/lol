<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 1.4.2017
 * Time: 14:02
 */


$countItems = 10;
$numPages = ceil($countItems / $step);

$tableId = 'BonusHours';
?>
<div class="widget widget-table action-table">
    <div class="widget-header"><i class="icon-time"></i>
        <h3>Bonus sati
            <input type="hidden" id="<?php echo $tableId ?>" value="1"/>
            <?php if ($numPages > 1) { ?>
                <a href="#back" id="<?php echo $tableId ?>left">
                    <i class="icon-chevron-left" onclick="leftRight('1__<?php echo $tableId . '__' . $numPages . '__' . $step . '__' . $countItems ?>')"></i>
                </a>
                <span class="center" id="<?php echo $tableId ?>PageNum">1/<?php echo $numPages?></span>
                <a href="#next" id="<?php echo $tableId ?>right">
                    <i class="icon-chevron-right" onclick="leftRight('2__<?php echo $tableId . '__' . $numPages . '__' . $step . '__' . $countItems ?>')"></i>
                </a>
            <?php } ?>

        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th width="20"> RB</th>
                <th> Username</th>
                <th width="40"> Br. Sati</th>
                <th width="40"> Bonus</th>
                <th width="40"> Očekivano</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 1; $i <= 10; $i++) {
                $numHours = $i * 15; ?>
                <tr id="<?php echo "$tableId$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                    <td class="center"><?php echo $i?></td>
                    <td> Chumpitas</td>
                    <td class="center"><?php echo $numHours ?></td>
                    <td class="center"><?php echo countBonus($i * 15) ?></td>
                    <td class="center"> <?php echo nextBonus($numHours); ?></td>
                </tr>
            <?php } ?>
            </tbody>


        </table>
    </div>

</div>