<?php

$result = new result();
$allresults = $result->getSumResultByHero();
$countItems = count($allresults);
$numPages = ceil($countItems / $step);
$tableId = 'tabByHero';


?>
<div class="widget widget-table action-table">
    <div class="widget-header"><i class="icon-trophy"></i>
        <h3>LOL takmičenje
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
        <div class="controls">
            <!-- Button to trigger modal -->
            <a href="unos_rezultata.php" role="button" class="btn">Dodaj rezultate</a>
        </div> <!-- /controls -->
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th width="20"> RB</th>
                <th> Username</th>
                <th width="150" class="center"> Champion</th>
                <th width="60"> Br. Pobeda</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;

            foreach ($allresults as $item) { ?>
                <tr id="<?php echo "$tableId$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                    <td class="center"><?php echo $i ?></td>
                    <td><?php echo $item->uusername ?></td>
                    <td class="center"><?php echo $item->heroname ?></td>
                    <td class="center"><?php echo $item->value ?></td>
                </tr>
                <?php $i++;
            }
            unset($result, $allresults, $countItems, $numPages, $tableId) ?>
            </tbody>

        </table>


    </div>

</div>
