<?php
class Netresearch_Magebid_Model_Ebay_Miscellaneous extends Mage_Core_Model_Abstract
{
	protected $_handler;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_miscellaneous');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_miscellaneous');
    }	
	
	public function getEbayTime()
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();	
					
		return $this->_handler->getEbayTime();	
	}	
	
	
	public function geteBayDetails($DetailName)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		return $this->_handler->geteBayDetails($DetailName);
	}
	
	public function geteBayCategories()
	{
		//Check Cat Version
		$res = $this->_handler->geteBayCategories();
		
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		//If Version in Magebid is older then Version in Ebay -> Update
		if (Mage::getSingleton('magebid/configuration')->getCategoryVersion()<$res->CategoryVersion)
		{
			if ($res = $this->_handler->geteBayCategories('ReturnAll',0))
			{				
				//Daily Log
				Mage::getModel('magebid/daily_log')->logCall();					
				
				Mage::getSingleton('magebid/configuration')->setCategoryVersion($res->CategoryVersion);
				return $res;
			}
		}
		else
		{
			Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Your categorie tree is already up to date'));			
			return false;
		}
	}	
}
?>
