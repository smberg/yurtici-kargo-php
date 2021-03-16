<?php
require_once "../vendor/autoload.php";

$request = new YurticiKargo\Request();
$request->setUser("YKTEST", "YK")->init("test");


$queryShipment = $request->queryShipment("SBG5448C616D8");

echo '<pre>';
print_r($queryShipment->getResultData());
echo '</pre>';