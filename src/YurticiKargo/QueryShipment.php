<?php
namespace YurticiKargo;

class QueryShipment 
{
    private $resultData;
    private $shippingDeliveryDetailVO;
    private $shippingDeliveryItemDetailVO;

    public function __construct($resultData)
    {
        $this->resultData = $resultData;
        $this->shippingDeliveryDetailVO = $resultData->ShippingDeliveryVO->shippingDeliveryDetailVO;
        if(isset($this->shippingDeliveryDetailVO->shippingDeliveryItemDetailVO)) {
            $this->shippingDeliveryItemDetailVO = $this->shippingDeliveryDetailVO->shippingDeliveryItemDetailVO;
        }
    }
    
    /**
     * Servisten dönen tüm değerler
     *
     * @return object
     */
    public function getResultData()
    {
        return $this->resultData;
    }
    
    /**
     * Kargonun taşınma geçmişi
     *
     * @return object|boolean
     */
    public function getHistory()
    {
        if(isset($this->shippingDeliveryItemDetailVO)) {
            $history = $this->shippingDeliveryItemDetailVO->invDocCargoVOArray;
            return $history;
        } else {
            return false;
        }
    }
    
    /**
     * Kargo takip adresi
     *
     * @return string
     */
    public function getTrackingUrl()
    {
        return $this->shippingDeliveryItemDetailVO->trackingUrl;
    }
    
    /**
     * Kargonun geçerli durum bilgisi
     *
     * @return string
     */
    public function getLatestStatus()
    {
        return $this->shippingDeliveryItemDetailVO->cargoReasonExplanation;
    }
    
    /**
     * Kargo takip numarası
     *
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->shippingDeliveryItemDetailVO->docId;
    }
    
    /**
     * Kargo göndericisinin bilgileri
     *
     * @return array
     */
    public function getSender()
    {
        $sender = array();
        $sender['senderCustId'] = $this->shippingDeliveryItemDetailVO->senderCustId;
        $sender['senderCustName'] = $this->shippingDeliveryItemDetailVO->senderCustName;
        $sender['senderAddressTxt'] = $this->shippingDeliveryItemDetailVO->senderAddressTxt;
        return $sender;
    }
    
    /**
     * Kargo alıcısının bilgileri
     * 
     * @return array
     */
    public function getReceiver()
    {
        $receiver = array();
        $receiver['receiverCustId'] = $this->shippingDeliveryItemDetailVO->receiverCustId;
        $receiver['receiverCustName'] = $this->shippingDeliveryItemDetailVO->receiverCustName;
        $receiver['receiverAddressTxt'] = $this->shippingDeliveryItemDetailVO->receiverAddressTxt;
        return $receiver;
    }
}