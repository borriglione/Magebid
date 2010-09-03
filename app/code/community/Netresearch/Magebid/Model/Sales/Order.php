<?php
/**
 * Netresearch_Magebid_Model_Sales_Order
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Sales_Order extends Mage_Sales_Model_Order
{
    /**
     * Order state protected setter.
     * 
     * Dispatch Event, which is catched by Netresearch_Magebid_Model_Order_Observer to change the ebay status
     * By default allows to set any state. Can also update status to default or specified value
     * Сomplete and closed states are encapsulated intentionally, see the _checkState()
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
     	$comment = Mage::getSingleton('magebid/order_status')->setEbayStatus($this,$state,$comment);  
    	return parent::_setState($state, $status, $comment, $isCustomerNotified, $shouldProtectState);
    }
}
?>