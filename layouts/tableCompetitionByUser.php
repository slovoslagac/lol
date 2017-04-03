<?php

$result = new result();
$allresults = $result->getSumResult();
$countItems = count($allresults);
$numPages = ceil($countItems / $step);
$tableId = 'tabSum';


?>
<div class="widget widget-table action-table">
    <div class="widget-header"><i class="icon-trophy"></i>
        <h3>LOL takmičenje
            <input type="hidden" id="<?php echo $tableId ?>" value="1"/>
            <?php if ($numPages > 1) { ?>
                <a href="#back" id="<?php echo $tableId ?>left">
                    <i class="icon-chevron-left" onclick="leftRight('1__<?php echo $tableId . '__' . $numPages . '__' . $step . '__' . $countItems ?>')"></i>
                </a>
                <span class="center" id="<?php echo $tableId ?>PageNum">1/<?php echo $numPages ?></span>
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
                <th width="40"> Uk. Poena</th>
                <th width="40"> Preostalo poena</th>
                <th width="40"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;

            foreach ($allresults as $item) { ?>
                <tr id="<?php echo "$tableId$i" ?>" >
                    <td class="center"><?php echo $i ?></td>
                    <td><?php echo $item->uusername ?></td>
                    <td class="center"><?php echo $item->value ?></td>
                    <td class="center"><?php echo $item->value - $item->used_points?></td>
                    <td class="center"><a href="#vracanje" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a></td>
                </tr>
                <?php $i++;
            }
            $rest = fmod($countItems, $step);
            $numOfRows = $step - $rest;
            for ($k = 1; $k <= $numOfRows; $k++) { ?>
                <tr id="add<?php echo "$tableId$k" ?>" <?php echo ($numPages > 1) ? "class=\"hide\"" : "" ?>>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>


            <?php } unset($result, $allresults, $countItems, $numPages, $tableId) ; ?>
            </tbody>

        </table>


    </div>

</div>