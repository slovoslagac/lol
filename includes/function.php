<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16.3.2017
 * Time: 13:01
 */

function redirectTo($location = null) {
    if($location != null) {
        header("Location:{$location}");
        exit;
    }
}


if (!function_exists('password_verify')){
    function password_verify($password, $hash){
        return (crypt($password, $hash) === $hash);
    }
}


function countBonus($val){
    if($val < 30) {
        return 0;
    } elseif ($val < 60) {
        return 1;
    } elseif ($val <90) {
        return 3 ;
    } elseif ($val <120) {
        return 6;
    } elseif($val <150) {
        return 10;
    } else {
        return 20;
    }
}




function nextBonus($val) {
    $date = new DateTime();
    $day = $date->format('j');
    $sumDays = $date->format('t');
    $result = round($val/$day * $sumDays);

    return $result;
}

function logAction($action, $message, $file = 'log.txt')
{
    $logfile = SITE_ROOT . DS . 'log' . DS . $file;

    if ($handle = fopen($logfile, 'a')) {
        $timestamp = strftime("%d.%m.%Y %H:%M:%S", time());
        $content = "$timestamp | $action : $message\n";
        fwrite($handle, $content);
        fclose($handle);
    } else {
        echo "Nije uspelo logovanje";
    }
}


function cmp($a, $b){
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

function monthName($val){
    $monthArray = array(1=>"JANUAR",2=>"FEBRUAR", 3=>"MART", 4=>"APRIL", 5=>"MAJ", 6=>"JUN", 7=>"JUL", 8=>"AVGUST", 9=>"SEPTEMBAR", 10=>"oKTOBAR", 11=>"NOVEMBAR", 12=>"DECEMBAR");
    return $monthArray[$val];
}

function getstockstatus(){
    global $conn;
    $sql = $conn->prepare("select s.productid, s.name, s.typeid, s.amount, s.sumprice, s.current_price, s.amount_cm, s.price_cm,
s.current_price_cm, s.amount + p.amount_cm - s.amount_cm - p.amount amount_sm, p.amount sale_amount, p.sum_price sale_sumprice, p.amount_cm sale_amount_cm, p.sum_price_cm sale_sum_price_cm
from
(
select a.productid, a.name, a.typeid, sum(a.amount) amount, sum(a.price) sumprice, sum(a.price)/sum(a.amount) current_price,  sum(a.amount_cm) amount_cm, sum(a.price_cm) price_cm,
case when sum(a.amount_cm) > 0 then sum(a.price_cm)/sum(a.amount_cm) else 0 end current_price_cm
from
(
select o.id, o.workerid, o.`timestamp`, o.supplierid, s.status, s.amount, s.productid, s.price * s.amount price, p.name, p.typeid,
case when month(o.timestamp) = EXTRACT(month FROM (NOW())) and year(o.timestamp) = extract(year from(now())) then s.amount else 0 end amount_cm,
case when month(o.timestamp) = EXTRACT(month FROM (NOW())) and year(o.timestamp) = extract(year from(now())) then s.amount*s.price else 0 end price_cm
from orders o, supplies s, products p
where o.id = s.orderid
and p.id = s.productid
) a
group by a.productid, a.name, a.typeid ) s
left join
(select b.productid, sum(b.amount) amount, sum(b.sum_price) sum_price, sum(b.amount_cm) amount_cm, sum(b.sum_price_cm) sum_price_cm
from
(
select sd.productid, br.numProducts amount, br.numProducts* br.price sum_price,
case when month(b.tstamp) = EXTRACT(month FROM (NOW())) and year(b.tstamp) = extract(year from(now())) then br.numProducts else 0 end amount_cm,
case when month(b.tstamp) = EXTRACT(month FROM (NOW())) and year(b.tstamp) = extract(year from(now())) then br.numProducts* br.price else 0 end sum_price_cm
from billsrows br, bills b, sellingproductsdetails sd
where br.billrid =b.id
and b.type = 1
and br.sellingproductid = sd.selingproductid ) b
group by b.productid) p
on s.productid = p.productid
order by 3,2");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);
    return $result;
}



function getSonyTime ($type) {
    global $conn;
    $sql = $conn->prepare("select br.numProducts, br.sellingproductid, b.tstamp, b.type, sp.name,
case when name like '%3h%' then br.numProducts * 180 else br.numProducts end value
from billsrows br, sellingproducts sp, bills b
where br.sellingproductid = sp.id
and br.billrid = b.id
and sp.typeid = 6
and br.type = :tp
and b.tstamp > now() - interval 1 day
order by 4, 3") ;
    $sql->bindParam(":tp", $type);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);
    return $result;

}