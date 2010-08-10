<?php
class Netresearch_Magebid_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/configuration');
    }
	
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
	
	public function getCategoryVersion()
	{
		return $this->load('category_version','key')->getValue();
	}
	
	public function setCategoryVersion($version)
	{
		if ($version=="") return false;
	
		$data = array('key'=>'category_version','value'=>$version);
		$this->load('category_version','key')->addData($data)->save();
	}	
	
	public function getCategoryFeaturesVersion()
	{
		return $this->load('category_features_version','key')->getValue();
	}	
	
	public function setCategoryFeaturesVersion($version)
	{
		if ($version=="") return false;
			
		$data = array('key'=>'category_features_version','value'=>$version);
		$this->load('category_features_version','key')->addData($data)->save();
	}
	
	public function getLastSellerEvent()
	{
		if ($last_update = $this->load('seller_event_update','key')->getValue())
		{
			//add a small time delay of 10min
			$time = Mage::getModel('core/date')->timestamp($last_update);
			$time = $time-(60*10);
			return Mage::getModel('core/date')->gmtDate(null, $time);			
			
			return $last_update;
		}
		else //first update
		{
			$now = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'); 
			$this->setKey('seller_event_update')->setValue($now)->save();
		}
	}
	
	public function setLastSellerEvent($now)
	{
		$this->load('seller_event_update','key')->setValue($now)->save();
	}
	
	public function getLastSellerTransactions()
	{
		if ($last_update = $this->load('seller_transactions_update','key')->getValue())
		{
			//add a small time delay of 10min
			$time = Mage::getModel('core/date')->timestamp($last_update);
			$time = $time-(60*10);
			return Mage::getModel('core/date')->gmtDate(null, $time);			
			
			return $last_update;
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
	
	public function setLastSellerTransactions($now)
	{
		$this->load('seller_transactions_update','key')->setValue($now)->save();
	}	
}
?>
