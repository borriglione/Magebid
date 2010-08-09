<?php
class Netresearch_Magebid_Model_Sales_Order extends Mage_Sales_Model_Order
{
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