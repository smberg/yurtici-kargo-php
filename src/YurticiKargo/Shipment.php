<?php
namespace YurticiKargo;

use Exception;

class Shipment 
{
    private $defaults = array();
    private $requiredFields = array();
    private $shipmentDetails = array();

    public function __construct()
    {
        $this->requiredFields = array("receiverCustName","receiverAddress","receiverPhone1","invoiceKey","cargoKey");
        $this->defaults = array(
            "cargoKey"           => "", // String (20)  (YK-Şube bu bilgiyi gönderi veya kargo üzerinde text/barkodlu olarak görmelidir.)
            "invoiceKey"         => "", // String (20)
            "receiverCustName"   => "", // Alıcı Adı Min 5 karakter olmalı en az 4 harf içermelidir.            
            "receiverAddress"    => "", // Min 10 (Harf/rakam) max 200 karakter olabilir.
            "cityName"           => "",
            "townName"           => "",
            "receiverPhone1"     => "", // String (20) Alan kodu ile birlikte 10 adet rakamdan oluşmalıdır. Örn: 02123652426
            "receiverPhone2"     => "",
            "receiverPhone3"     => "",
            "emailAddress"       => "", // Alıcı Müşteri mail adresi
            "taxOfficeId"        => "", // Vergi Dairesi Kodu
            "taxNumber"          => "", // Vergi No (Şahıs Şirketleri için 11 , Normal Şirketler için 10 hane gönderilebilir.) 
            "taxOfficeName"      => "", // Vergi Dairesi Adı
            "desi"               => "", // Double(9,3)
            "kg"                 => "", // Double(9,3)
            "cargoCount"         => "", // Integer (4)
            "waybillNo"          => "", // Sevk İrsaliye No (Ticari gönderilerde zorunludur)            
            "specialField1"      => "",
            "specialField2"      => "",
            "specialField3"      => "",
            "ttInvoiceAmount"    => "", // Double (18,2) Separator (.) olmalıdır.
            "ttDocumentId"       => "",
            "ttCollectionType"   => "", // ttCollectionType  = 0 olduğu Tahsilatlı Teslimat gönderilerinde;  ttInvoiceAmount, ttDocumentId, ttDocumentSaveType  alanları boş gönderilmemelidir.
                                        // ttCollectionType  = 1 ve Kredi Kartı ile Tahsilatlı Teslimat olduğu durumlarda,  ttInvoiceAmount, ttDocumentId, ttDocumentSaveType , dcSelectedCredit,  dcCreditRule alanları boş gönderilmemelidir.  
            "ttDocumentSaveType" => "", // Tahsilâtlı teslimat ürünü hizmet bedeli gönderi içerisinde mi? (0 – Aynı fatura,1 – farklı fatura)     
            "dcSelectedCredit"   => "", // Müşteri Taksit Seçimi (Taksit Sayısı)            
            "dcCreditRule"       => "", // Taksit Uygulama Kriteri 0: Müşteri Seçimi Zorunlu, 1: Tek Çekime izin ver            
            "description"        => "",
            "orgGeoCode"         => "", // Müşteri Adres Kodu
            "privilegeOrder"     => "", // Varış merkezi belirleme öncelik sırası
            "custProdId"         => "",
            "orgReceiverCustId"  => "",
        );
    }
    
    /**
     * Kargo bilgileri ekle
     * Zorunlu alanlar: receiverCustName, receiverAddress, receiverPhone1, invoiceKey, cargoKey
     *
     * @param  array $shipmentDetails
     * @return Shipment
     */
    public function setShipmentDetails($shipmentDetails)
    {
        foreach($this->requiredFields as $field) 
        {
            if(!array_key_exists($field, $shipmentDetails)) {
                throw new Exception($field." tanımlı olması gerekiyor!");
            } 
        }

        $this->shipmentDetails = array_merge($this->defaults, $shipmentDetails);
        return $this;
    }
    
    /**
     * Kargo bilgileri getir
     *
     * @return array
     */
    public function getShipmentDetails()
    {
        if(empty($this->shipmentDetails)) {
            throw new Exception("Öncelikle kargo detaylarını eklemeniz gerekmekte!");
        }

        return $this->shipmentDetails;
    }
}