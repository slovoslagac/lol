<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.5.2017
 * Time: 15:55
 */
class financialoffers
{
    public $userid;
    public $bonusId;
    public $numHours;
    public $numMinutes;


    public function __construct($userid, $numHours)
    {
        $this->userid = $userid;
        $this->numHours = $numHours;
        $this->numMinutes = $numHours * 60;
        $this->bonusId = $this->calculateBonusID($numHours);

    }

    public function calculateBonusID($val){
        $bonusOffers = array(1=>65, 3=>66, 6=>67, 10=>68, 20=>69);
        $offerId = $bonusOffers[$val];
        return $offerId;
    }


}