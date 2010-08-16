<?php
/**
 * Netresearch_Magebid_Model_Sales_Order
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Sales_Order extends Mage_Sales_Model_Order
{
    /**
     * Set a Magento order-status after creating a new Magento Order from an eBay Auction
     * 
     * @param string $state if Multiselect for the order status selection is allowed 
     * @param boolean $status 
     * @param string $comment 
     * @param boolean $isCustomerNotified If the customer should be notified
     *
     * @return object
     */	      
    public function setState($state, $status = false, $comment = '', $isCustomerNotified = false)
    {
        $this->setData('state', $state);
        if ($status) {
            if ($status === true) {
                $status = $this->getConfig()->getStateDefaultStatus($state);
            }
						
			//Set Event
			Mage::dispatchEvent('sales_model_order_set_state', array('order' => $this,'change_state'=>$status));
			
            $this->addStatusToHistory($status, $comment, $isCustomerNotified);
        }
        return $this;
    }
}
?>