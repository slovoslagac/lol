<?php

/**
 * Created by PhpStorm.
 * User: petar.prodanovic
 * Date: 25.5.2017.
 * Time: 21.07
 */
class supplies
{
    public $amount;
    public $orderid;
    public $productid;
    public $price;
    public $status=1;

    public function __construct($amount, $orderid, $productid, $price)
    {
        $this->amount=$amount;
        $this->orderid=$orderid;
        $this->productid=$productid;
        $this->price=$price;
    }

    public function addSupplie(){
        global $conn;
        $sql = $conn->prepare("insert into supplies (status,amount,orderid,productid,price) values (:st,:am, :ord, :prid, :price)");
        $sql->bindParam(":st",$this->status);
        $sql->bindParam(":am",$this->amount);
        $sql->bindParam(":ord",$this->orderid);
        $sql->bindParam(":prid",$this->productid);
        $sql->bindParam(":price",$this->price);
        $sql->execute();

    }

}