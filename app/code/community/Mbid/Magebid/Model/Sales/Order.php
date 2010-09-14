<?php
/**
 * Mbid_Magebid_Model_Sales_Order
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Sales_Order extends Mage_Sales_Model_Order
{
    /**
     * Check value to avoid a double-feedback-message
     * @var boolean
     */	
	protected $_feedback_was_sent = false;

    /**
     * Order state protected setter.
     * 
     * Dispatch Event, which is catched by Mbid_Magebid_Model_Order_Observer to change the ebay status
     * By default allows to set any state. Can also update status to default or specified value
     * Сomplete and closed states are encapsulated intentionally, see the _checkState()
     * 
     * This function is for Magento >= Version 1.4.0.0
     *
     * @param string $state
     * @param string|bool $status
     * @param string $comment
     * @param bool $isCustomerNotified
     * @param $shouldProtectState
     * @return Mage_Sales_Model_Order
     */
    protected function _setState($state, $status = false, $comment = '', $isCustomerNotified = null, $shouldProtectState = false)
    { 
     	if (!$this->_feedback_was_sent) $comment = Mage::getSingleton('magebid/order_status')->setEbayStatus($this,$state,$comment);  
    	return parent::_setState($state, $status, $comment, $isCustomerNotified, $shouldProtectState);
    }
    
    /**
     * Declare order state
     *
     * This function is for Magento < Version 1.4.0.0
     *
     * @param string $state
     * @param string $status
     * @param string $comment
     * @param bool $isCustomerNotified
     * @return  Mage_Sales_Model_Order
     */
    public function setState($state, $status = false, $comment = '', $isCustomerNotified = false)
    {
     	$comment = Mage::getSingleton('magebid/order_status')->setEbayStatus($this,$state,$comment); 
     	$this->_feedback_was_sent = true; 
    	return parent::setState($state, $status, $comment, $isCustomerNotified);
    }
}
?>