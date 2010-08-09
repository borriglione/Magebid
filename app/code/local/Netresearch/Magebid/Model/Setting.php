<?php
class Netresearch_Magebid_Model_Setting extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('magebid/setting');
    }
	
    public function getAppMode()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/app_mode');
    }	

    public function getEbaySiteId()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/ebay_site_id');
    }	
	
    public function getSandboxDevKey()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/sandbox_dev_key');
    }	
	
    public function getSandboxAppKey()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/sandbox_app_key');
    }			

    public function getSandboxCertId()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/sandbox_cert_id');
    }	

    public function getProductionDevKey()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/production_dev_key');
    }					
	
    public function getProductionAppKey()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/production_app_key');
    }		
	
    public function getProductionCertId()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/production_cert_id');
    }	

    public function getToken()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/token');
    }	
	
    public function getTokenMode()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/token_mode');
    }
	
    public function getPaypalMail()
    {
		return Mage::getStoreConfig('magebid/magebid_paypal/email');
    }	
	
    public function getOrderStatusPaymentReceived()
    {
		return explode(",",Mage::getStoreConfig('magebid/magebid_order_status/payment_received'));
    }	
	
    public function getOrderStatusShipped()
    {
		return explode(",",Mage::getStoreConfig('magebid/magebid_order_status/order_send'));
    }	
	
    public function getOrderStatusReviewed()
    {
		return explode(",",Mage::getStoreConfig('magebid/magebid_order_review/order_reviewed'));
    }		
	
    public function checkMakeAutomaticReview()
    {
		return Mage::getStoreConfig('magebid/magebid_order_review/check');
    }		
	
    public function getReviewText()
    {
		return Mage::getStoreConfig('magebid/magebid_order_review/review_text');
    }			
	
    public function checkMakeOrderStatusComments()
    {
		return Mage::getStoreConfig('magebid/magebid_order_status/add_comment');
    }			
}
?>
