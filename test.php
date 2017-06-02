<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

$currentName = 'Coca12';
$currentType = 1;
$currentProduct = new sellingproduct($currentName, $currentType);
$currentProduct->addNewSellingProduct();
$currentProduct->getSellingProductByName();

var_dump($currentProduct);