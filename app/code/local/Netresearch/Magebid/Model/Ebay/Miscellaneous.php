<?php
/**
 * Netresearch_Magebid_Model_Ebay_Miscellaneous
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Ebay_Miscellaneous extends Mage_Core_Model_Abstract
{
    /**
     * Handler for Calls to eBay
     * @var object Netresearch_Magebid_Model_Ebay_Ebat_Miscellaneous
     */	
	protected $_handler;
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/ebay_miscellaneous');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_miscellaneous');
    }	
	
    /*
	public function getEbayTime()
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();	
					
		return $this->_handler->getEbayTime();	
	}	
	*/
	
    /**
     * GeteBayDetailsCall f.e. import payment/shipping methods
     * 
     * @param string $DetailName Defines import task
     *
     * @return array
     */  
	public function geteBayDetails($DetailName)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		return $this->_handler->geteBayDetails($DetailName);
	}
	
    /**
     * get eBay Categories Call
     *
     * @return array|boolean If call was successful return array, else false
     */  
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
	
    /**
     * get eBay Categories Features Call
     *
     * @return array|boolean If call was successful return array, else false
     */  
	public function getCategoriesFeatures()
	{
		//Check Category Features Version
		$res = $this->_handler->getCategoryFeatures();
		
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		//If Version in Magebid is older then Version in Ebay -> Update
		if (Mage::getSingleton('magebid/configuration')->getCategoryFeaturesVersion()<$res->CategoryVersion)
		{
			if ($res = $this->_handler->getCategoryFeatures('ReturnAll'))
			{				
				//Daily Log
				Mage::getModel('magebid/daily_log')->logCall();					
				
				//Set current version
				//Mage::getSingleton('magebid/configuration')->setCategoryFeaturesVersion($res->CategoryVersion);
				return $res;
			}
		}
		else
		{
			Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Your Category Features are already up to date'));			
			return false;
		}		
		

		
		return true;
	}		
}
?>
