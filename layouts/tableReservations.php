<!--                    Pocetak rezervacija -->
<?php
$currentdate = new DateTime();
$res = new reservation();
$allreservations = $res->getAllReservations();
$countItems = 0;
foreach ($allreservations as $item) {
    if ($item->confirmed == null) {

        $countItems++;
    }
}
$numPages = ceil($countItems / $step);
$tableId = 'tabReservations';
?>
<div class="widget widget-table action-table" id="reservations">
    <div class="widget-header"><i class="icon-time"></i>
        <h3>Rezervacije
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
            <a href="#rezervacija" role="button" class="btn" data-toggle="modal">Dodaj novu rezervaciju</a>

            <!-- Modal -->

            <div id="rezervacija" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Unos nove rezervacije</h3>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-body">
                        <input type="datetime-local" name="datetime" min="<?php echo $now ?>" value="<?php echo $now ?>" required/><br/>
                        <input type="text" list="user" name="user">
                        <datalist id="user" required>
                            <?php foreach ($allusers as $item) { ?>
                                <option value="<?php echo $item->arenausername ?>"></option>
                            <?php } ?>
                        </datalist>
                        <input type="text" id="user_pc" name="pc" value="" placeholder="11,12,13,14" class="login" required/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
                        <button class="btn btn-primary" type="submit" name="makeReservation">Napravi rezervaciju</button>
                    </div>
                </form>
            </div>

        </div> <!-- /controls -->
        <!--<div class="add"><i class="icon-plus-sign"></i>&nbsp;&nbsp;dodaj novu rezervaciju</div>-->
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> Datum</th>
                <th> Vreme</th>
                <th> Kompjuter(i)</th>
                <th> Username</th>
                <th> Akcija</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($allreservations as $item) {
                if ($item->confirmed == null) {
                    ?>
                    <tr id="<?php echo "$tableId$i" ?>" <?php echo ($i > $step) ? "class=\"hide\"" : "" ?>>
                        <td class="center"><?php echo $item->date ?></td>
                        <td class="center"><b><?php echo $item->time ?></b></td>
                        <td class="center"><b><?php echo $item->reservation ?></b></td>
                        <td><?php echo $item->username ?></td>
                        <td class="td-actions">
                            <div>
                                <!-- Button to trigger modal -->
                                <a href="#izvrseno" role="button" class="btn btn-small btn-success" data-toggle="modal" onclick="confirmReservation(<?php echo $item->id ?>)"><i
                                        class="btn-icon-only icon-ok"> </i></a>
                                <a href="#ponisti" role="button" class="btn btn-small btn-danger" data-toggle="modal" onclick="cancelReservation(<?php echo $item->id ?>)"><i
                                        class="btn-icon-only icon-remove"> </i></a>


                            </div> <!-- /controls -->
                        </td>
                    </tr>
                    <?php $i++;
                }
            }
            unset($res, $allreservations);


            $rest = fmod($countItems, $step);
            $numOfRows = $step - $rest;
            if ($rest > 0) {
            for ($k = 1; $k <= $numOfRows; $k++) { ?>
                <tr id="add<?php echo "$tableId$k" ?>" <?php echo ($numPages > 1) ? "class=\"hide\"" : "" ?>>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


            <?php } }?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal -->
<div id="izvrseno" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Potvrda rezervacije</h3>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="modal-body">
            <p>Rezervacija je izvršena i kompjuteri su izdati.</p>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"> Poništi</button>
            <button class="btn btn-primary" type="submit" name="confirmation" id="confirmation">Potvrdi</button>
        </div>
    </form>
</div>

<!-- Modal -->
<div id="ponisti" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Otkazivanje rezervacije</h3>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="modal-body">
            <p>Rezervacija ne može biti izvršena, pa se otkazuje.</p>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Poništi</button>
            <button class="btn btn-primary" name="cancelation" id="cancelation">Otkaži rezervaciju</button>
        </div>
    </form>
</div>


<!--Kraj rezervacija-->