<?php

$usr = new credit();
$userCredits = $usr->getSumAllUserCredits();
$countItems = count($userCredits);
$numPages = ceil($countItems / $step);
$tableId = 'tabCredits';

?>
<!--Pocetak Dugovanja-->
<div class="widget widget-table action-table">
    <div class="widget-header"><i class="icon-money"></i>
        <h3>Dugovanja
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
        <div class="controls">
            <!-- Button to trigger modal -->
            <a href="#dugovanje" role="button" class="btn" data-toggle="modal">Dodaj novo dugovanje</a>

            <!-- Modal -->
            <div id="dugovanje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Unos novog dugovanja</h3>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-body">
                        <select id="selectUser" name="selectUser" onchange="myFunction()">
                            <option value="0"></option>
                            <?php foreach ($userCredits as $item) {
                                ?>
                                <option
                                    value="<?php $credit = ($item->value == '') ? '0' : $item->value;
                                    echo $item->id . '__' . $credit ?>"><?php echo $item->username ?></option>

                                <?php
                            } ?>
                        </select>
                        <input type="number" id="amountChosen" name="amountChosen" value="" placeholder="Iznos dugovanja" class="login"/>
                        <p id="amount"></p>

                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                        <button class="btn btn-primary" type="submit" name="saveCredit">Unesi dugovanje</button>
                    </div>
                </form>
            </div>
        </div> <!-- /controls -->
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> Igrač</th>
                <th> Uk. Iznos</th>
                <th> Koliko dugo duguje</th>
                <th> Akcija</th>
            </tr>
            </thead>
            <tbody>
            <?php $maxDay = '';
            $sumCredit = 0;
            $i = 1;
            foreach ($userCredits as $item) {
                if ($item->value > 0) {
                    $sumCredit = $sumCredit + $item->value; ?>
                    <tr id="<?php echo "$tableId$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                        <td value="<?php echo $item->id ?>"><b><?php echo $item->username ?></b>
                        </td>
                        <td class="center"><?php echo "$item->value Din" ?></td>
                        <td><?php echo ($item->num_days > 1) ? "$item->num_days dana" : ($item->num_days == 1) ? "$item->num_days dan" : "Od danas" ?></td>
                        <td class="td-actions">
                            <div>
                                <!-- Button to trigger modal -->
                                <a data-toggle="modal" href="#vracanje" id="updateUser<?php echo $item->id ?>" data-id="<?php echo $item->id ?>" role="button"
                                   class="btn btn-small btn-success"
                                   onclick="updateUser('<?php echo $item->id . "__" . $item->username . "__" . $item->value ?>')">
                                    <i class="btn-icon-only icon-ok"></i></a>
                                <!--        <button href="#vracanje" role="button" class="btn btn-small btn-success"data-toggle="modal"><i class="btn-icon-only icon-ok"> </i></button>-->

                            </div> <!-- /controls -->
                        </td>
                    </tr>
                    <?php $i++;
                }
            } ?>
            <tr>
                <td colspan="3"></td>
                <td class="center"><b><?php echo "$sumCredit Din" ?></b></td>
            </tr>
            </tbody>

        </table>
    </div>
</div>
<!-- Modal -->
<div id="vracanje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Unos novog dugovanja</h3>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="modal-body">
            <p id="userCredit"></p>
            <input type="hidden" name="currentUserName" id="currentUserName" value=""/>
            <input type="hidden" name="currentUserId" id="currentUserId" value=""/>
            <input type="number" id="amountDebit" name="amountDebit" value="" placeholder="Iznos vracenog duga" class="login" onchange="calculate()"/>
            <p id="currentDebit"></p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
            <button class="btn btn-primary" name="reduceCredit" type="submit">Unesi izmenu</button>
        </div>
    </form>
</div>

<!--Kraj Dugovanja-->
