<?php
namespace YurticiKargo;
use \SoapClient;

class Request 
{
    private $userName = '';
    private $password = '';
    private $apiURL = null;
    private $soapClient = null;
 
    /**
     * setUser
     *
     * username : “YKTEST”
     * password : “YK”
     * @param  string $username
     * @param  string $pass
     * @return Request
     */
    public function setUser($username,$pass)
    {
       $this->userName = $username;
       $this->password = $pass; 
       return $this;
    }
  
    /**
     * setApiURL
     * 
     * test: http://testwebservices.yurticikargo.com:9090/KOPSWebServices/ShippingOrderDispatcherServices?wsdl
     * prod: http://webservices.yurticikargo.com:8080/KOPSWebServices/ShippingOrderDispatcherServices?wsdl
     * @param  string $url
     * @return Request
     */
    public function setApiURL($url)
    {
        $this->apiURL = $url;
        return $this;
    }
    
    /**
     * init
     *
     * @param  string $status test || prod
     * @return Request
     */
    public function init($status)
    {
        if($status == 'test') {
            $this->setApiURL("http://testwebservices.yurticikargo.com:9090/KOPSWebServices/ShippingOrderDispatcherServices?wsdl");
            $this->setUser("YKTEST","YK");
        } else {
            $this->setApiURL("http://webservices.yurticikargo.com:8080/KOPSWebServices/ShippingOrderDispatcherServices?wsdl");
        }
            
        $this->soapClient = new SoapClient($this->apiURL, array("trace" => 1, "exception" => 0));
        return $this;
    }
    
    /**
     * Kargo oluşturma
     *
     * Zorunlu alanlar: "receiverCustName","receiverAddress","receiverPhone1","invoiceKey","cargoKey"
     * outFlag 0: Başarılı
     * outFlag 1: Hata Oluştu.
     * outFlag 2: Beklenmeyen Hata.
     * operationMessage: Kargo Durumu Açıklaması
     * errCode: Hata Kodu
     * errMessage: Hata Mesajı
     * @param  Shipment $shipmentDetails
     * @return mixed boolean | object
     */
    public function createShipment($shipmentDetails)
    {
        $finalValues = $shipmentDetails->getShipmentDetails();

        $result = $this->soapClient->__soapCall("createShipment", array(
            "createShipment" => array(
                "wsUserName"      => $this->userName,
                "wsPassword"      => $this->password,
                "userLanguage"    => "TR",
                "ShippingOrderVO" => $finalValues
            )
        ), NULL);

        return $result;
    }
    
    /**
     * Kargo durumu sorgulama
     *
     * @param  mixed $cargoInfo (string olduğunda kargo anahtarı olarak kabul edilir)
     * @param  bool $historical
     * @return QueryShipment
     */
    public function queryShipment($cargoInfo, $historical = true)
    {
        $type = gettype($cargoInfo);
        $defaults = array(
            "wsUserName" => $this->userName,
            "wsPassword" => $this->password,
            "wsLanguage" => "TR",
            "keys"       => "",
            "keyType" => "",
            "addHistoricalData" => $historical,
            "onlyTracking" => "",
        );
        $finalValues = array();
        if($type == "string") {
            $finalValues = $defaults;
            $finalValues["keys"] = $cargoInfo;
        } else {
            $finalValues = array_merge($defaults, $cargoInfo);
        }
        $result = $this->soapClient->__soapCall("queryShipment", array(
            "queryShipment" => $finalValues
        ), NULL);
        $queryShipment = new QueryShipment($result);
        return $queryShipment;
    }
    
    /**
     * Kargo anahtarı ile işlemi iptal et
     *
     * @param  string $cargoKey
     * @return object
     */
    public function cancelShipment($cargoKey)
    {
        $result = $this->soapClient->__soapCall("cancelShipment", array(
            "cancelShipment" => array(
                "wsUserName"   => $this->userName,
                "wsPassword"   => $this->password,
                "userLanguage" => "TR",
                "cargoKeys"    => $cargoKey
            )
        ), NULL);

        return $result;
    }
    
    /**
     * Benzersiz anahtar üret
     *
     * @param  int $characterCount 32 karaktere kadar sınırlı
     * @return string
     */
    public static function generateKey($characterCount = 17)
    {
        $limit = (int) $characterCount;
        return strtoupper(substr(md5(microtime()), 0, $limit));
    }
}