<?php
/**
 * Mbid_Magebid_Model_Setting
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Setting extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/setting');
    }
	
    /**
     * Return if Development Mode is activated or not
     *
     * @return boolean
     */	    
    public function getAppMode()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/app_mode');
    }	

    /**
     * Return the id of the eBay Site which is used
     *
     * @return int
     */	      
    public function getEbaySiteId()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/ebay_site_id');
    }	
	
    /**
     * Return the eBay User Token
     *
     * @return string
     */	 
    public function getToken()
    {
		return Mage::getStoreConfig('magebid/magebid_connection/token');
    }	
	
    /**
     * Return the Paypal Mail Adress of the Seller
     *
     * @return string
     */	
    public function getPaypalMail()
    {
		return Mage::getStoreConfig('magebid/magebid_paypal/email');
    }	
	
    /**
     * Return the Order Status when an order was payed, used for the automatic ebay feedback
     *
     * @return string
     */	      
    public function getOrderStatusPaymentReceived()
    {
		return explode(",",Mage::getStoreConfig('magebid/magebid_order_status/payment_received'));
    }	
	
    /**
     * Return the Order Status when an order was shipped, used for the automatic ebay feedback
     *
     * @return string
     */	       
    public function getOrderStatusShipped()
    {
		return explode(",",Mage::getStoreConfig('magebid/magebid_order_status/order_send'));
    }	
	
    /**
     * Return the Order Status when an order was review, used for the automatic ebay feedback
     *
     * @return string
     */	      
    public function getOrderStatusReviewed()
    {
		return explode(",",Mage::getStoreConfig('magebid/magebid_order_review/order_reviewed'));
    }		
	
    /**
     * Return the Review Text which should be given automatically to a buyer in eBay
     *
     * @return string
     */	       
    public function getReviewText()
    {
		return Mage::getStoreConfig('magebid/magebid_order_review/review_text');
    }			
	
    /**
     * Return true if magebid should leave a comment for an order when a feedback to ebay was given
     *
     * @return boolean
     */	      
    public function checkMakeOrderStatusComments()
    {
		return Mage::getStoreConfig('magebid/magebid_order_status/add_comment');
    }			
}
?>
