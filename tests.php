<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 21.9.2017
 * Time: 13:33
 */



$url = 'http://localhost/levelup/api/apiGetTournamentDetails.php?tournament=1';


$tmpData = json_decode(file_get_contents($url));


var_dump(($tmpData));

