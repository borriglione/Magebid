<?php
/**
 * Netresearch_Magebid_Model_Configuration
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Configuration extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/configuration');
    }
	
    /**
     * Return all available currency codes of Magento
     *
     * @return array
     */	    
	public function getAvailableCurrencyCodes()
	{
		$code_array = array();
		$codes = Mage::app()->getStore()->getAvailableCurrencyCodes();
		foreach ($codes as $value)
		{
			$code_array[$value] = $value;
		}
		
		return $code_array;
	}
	
    /**
     * Return the current version of the ebay category tree stored in magento
     *
     * @return int
     */	    	
	public function getCategoryVersion()
	{
		return $this->load('category_version','key')->getValue();
	}
	
    /**
     * Store the version-id of ebay category tree, which was imported
     *
     * @param int $version ebay category tree version
     *
     * @return void
     */	 	
	public function setCategoryVersion($version)
	{
		if ($version=="") return false;
	
		$data = array('key'=>'category_version','value'=>$version);
		$this->load('category_version','key')->addData($data)->save();
	}	
	
    /**
     * Return the current version of the ebay category features
     *
     * @return int
     */	   	
	public function getCategoryFeaturesVersion()
	{
		return $this->load('category_features_version','key')->getValue();
	}	
	
    /**
     * Store the version-id of ebay category features, which was imported
     *
     * @param int $version ebay category features version
     *
     * @return void
     */	 	
	public function setCategoryFeaturesVersion($version)
	{
		if ($version=="") return false;
			
		$data = array('key'=>'category_features_version','value'=>$version);
		$this->load('category_features_version','key')->addData($data)->save();
	}
	
    /**
     * Returns the "from" date for the seller events call
     * 
     * If there was set a date for the last update, take it and add a delay of 10min
     * If there is no date for the last update take a delay of 24 hours, and store the date(now) directly in the db
     *
     * @param int $version ebay category features version
     *
     * @return string
     */	 	
	public function getLastSellerEvent()
	{
		if ($last_update = $this->load('seller_event_update','key')->getValue())
		{
			//add a small time delay of 10min
			$time = Mage::getModel('core/date')->timestamp($last_update);
			$time = $time-(60*10);
			return Mage::getModel('core/date')->gmtDate(null, $time);			
		}
		else //first update
		{
			$now = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'); 
			$this->setKey('seller_event_update')->setValue($now)->save();
			$time = $now-(60*60*24);
			return Mage::getModel('core/date')->gmtDate(null, $time);	
		}
	}
	
    /**
     * Store the date of the last seller event update
	 *
     * @param string $now date of the current update
     *
     * @return void
     */	 
	public function setLastSellerEvent($now)
	{
		$this->load('seller_event_update','key')->setValue($now)->save();
	}
	
    /**
     * Returns the "from" date for the seller transactions call
     * 
     * If there was set a date for the last update, take it and add a delay of 10min
     * If there is no date for the last update take a delay of 24 hours, and store the date(now) directly in the db
     *
     * @return string
     */	 	
	public function getLastSellerTransactions()
	{
		if ($last_update = $this->load('seller_transactions_update','key')->getValue())
		{
			//add a small time delay of 10min
			$time = Mage::getModel('core/date')->timestamp($last_update);
			$time = $time-(60*10);
			return Mage::getModel('core/date')->gmtDate(null, $time);			
		}
		else //first update
		{
			$now = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'); 			
			$this->setKey('seller_transactions_update')->setValue($now)->save();
			
			//add a time delay of 24h
			$time = Mage::getModel('core/date')->timestamp($now);
			$time = $time-(60*60*24);
			return Mage::getModel('core/date')->gmtDate(null, $time);				
		}		
	}

    /**
     * Store the date of the last seller transactions update
	 *
     * @param string $now date of the current update
     *
     * @return void
     */	 	
	public function setLastSellerTransactions($now)
	{
		$this->load('seller_transactions_update','key')->setValue($now)->save();
	}	
}
?>
