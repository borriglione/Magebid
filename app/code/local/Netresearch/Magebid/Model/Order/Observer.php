<?php 
class Netresearch_Magebid_Model_Order_Observer extends Mage_Core_Model_Abstract
{
    /**
     * @param Mage_Observer $observer
     */
    public function change_order_state($observer)
    {	   
		//Get event
		$event = $observer->getEvent();

		//Get order
		$order = $event->getOrder();
		
		//Check if it is an eBay Order
		if (Mage::getModel('magebid/transaction')->load($order->getIncrementId(),'order_id')->getId())
		{		
			//Get status
			$old_status = $order->getStatus();
			$new_status = $event->getChangeState();
			
			//Set new Status on eBay
			Mage::getSingleton('magebid/order_status')->setEbayStatus($order,$new_status);			
		}
    }
}
