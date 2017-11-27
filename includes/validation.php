<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 26.11.2017
 * Time: 21:06
 */
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

//set the headers to be a json string
header('content-type: text/json');

//no need to continue if there is no value in the POST username
if(!isset($_POST['username']))
    exit;

//$ctrl_cmp_team = new cmp_team();
//$ctrl_result = $ctrl_cmp_team->getusername('username', $_POST['username']);


//prepare our query.
global $conn_cmp;
$query =  $conn_cmp->prepare('SELECT * FROM teams WHERE username = :name');
//let PDO bind the username into the query, and prevent any SQL injection attempts.
$query->bindParam(':name', $_POST['username']);
//execute the query
$query->execute();

//return the json object containing the result of if the username exists or not. The $.post in our jquery will access it.
echo json_encode(array('exists' => $query->rowCount() > 0));