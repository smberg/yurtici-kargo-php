# Installation

### Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require smberg/yurtici-kargo
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

### Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/smberg/yurtici-kargo-php/releases). Then, to use the bindings, include the `YurticiKargoBootstrap.php` file.

```php
require_once('/path/to/yurtici-kargo-php/YurticiKargoBootstrap.php');
```

# Examples

## Create a shipment request

```php
<?php
require_once "../vendor/autoload.php";

$request = new YurticiKargo\Request("test");
$request->setUser("YKTEST", "YK");

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
```

## Cancel a shipment request

```php
<?php
require_once "../vendor/autoload.php";

$request = new YurticiKargo\Request("test");
$request->setUser("YKTEST", "YK");

$cancelShipment = $request->cancelShipment("CARGO_KEY");

echo '<pre>';
print_r($cancelShipment);
echo '</pre>';
```

## Query cargo status

```php
<?php
require_once "../vendor/autoload.php";

$request = new YurticiKargo\Request("test");
$request->setUser("YKTEST", "YK");


$queryShipment = $request->queryShipment("SBG5448C616D8");

echo '<pre>';
// Servisten dönen tüm değerleri getirir
print_r($queryShipment->getResultData());

// Kargo takip numarası
echo $queryShipment->getTrackingNumber();

// Kargo takibi için adres
echo $queryShipment->getTrackingUrl();

// Gönderici bilgileri (array)
print_r($queryShipment->getSender());

// Alıcı bilgileri (array)
print_r($queryShipment->getReceiver());

// Kargonun güncel durumu
echo $queryShipment->getLatestStatus();

// Kargonun tüm hareketleri (array)
print_r($queryShipment->getHistory());

echo '</pre>';
```
