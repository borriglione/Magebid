<?php
class Netresearch_Magebid_Model_Ebay_Store extends Mage_Core_Model_Abstract
{
	protected $_handler;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_store');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_store');
    }		
	
	public function geteBayStoreCategories()
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		if ($res = $this->_handler->getStore())
		{				
			return $res->Store->CustomCategories;
		}
	}	
}
?>
