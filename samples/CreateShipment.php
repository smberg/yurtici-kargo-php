<?php
require_once "../vendor/autoload.php";

$request = new YurticiKargo\Request();
$request->setUser("YKTEST", "YK")->init("test");

$shipmentDetails = array(
    "receiverCustName" => "Berkay Gümüştekin",
    "receiverAddress" => "Test Mah. Deneme Sk. No:3",
    "receiverPhone1" => "05555555555",
    "invoiceKey" => "SBG".YurticiKargo\Request::generateKey(17),
    "cargoKey" => "SBG".YurticiKargo\Request::generateKey(10)
);
$shipment = new YurticiKargo\Shipment();
$shipment->setShipmentDetails($shipmentDetails);

$createShipment = $request->createShipment($shipment);

echo '<pre>';
print_r($createShipment);
echo '</pre>';