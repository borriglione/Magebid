<?php
class Netresearch_Magebid_Model_Ebay_Sale extends Mage_Core_Model_Abstract
{
	protected $_handler;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_sale');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_sale');
    }	
	
	public function setCompleteSale($transaction,$tasks)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		return $this->_handler->setCompleteSale($transaction,$tasks);	
	}			
	
}
?>
