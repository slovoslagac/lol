<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


//$currentDate = new dateTime();
//$currentMonth = $currentDate->format('n');
//$month = $currentMonth -1;

if (isset($_POST["calculate"])) {
    $bonus = new bonus;
    $month = $_POST["month"];
    $allBonusesCurrentMonth = $bonus->getResults($month);
    $bonus->deleteMonthlyValues($month);
    foreach ($allBonusesCurrentMonth as $item) {
        $hour = $item->this_month;
        if ($hour > 0) {
//            echo $i . '. ' . $item->id . ' - ' . countBonus($hour) . ' - - ' . $hour . ' - - ' . $month . '<br>';
//            $i++;

            $bonus->addMonthlyValues(countBonus($hour),$item->id,$month);
        }
    }

    unset($month);
}

//foreach($allBonusesCurrentMonth as $item){
//    $hour = $item->this_month;
//    echo $i .'. '.$item->id .'<br>';
//    $i++;
//}
?>
<html>
<body>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
    <h3>Odaberi mesec za koji se vrsi obracun.</h3>
    <input type="number" name="month" min="1" max="12">
    <button type="submit" name="calculate">Obračunaj</button>
</form>
</body>
</html>