<?php
require_once "../vendor/autoload.php";

$request = new YurticiKargo\Request("test");
$request->setUser("YKTEST", "YK");


$queryShipment = $request->queryShipment("SBG5448C616D8");

echo '<pre>';
print_r($queryShipment->getResultData());
echo '</pre>';
