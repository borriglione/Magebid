<?php

class Netresearch_Magebid_Model_System_Config_Source_Store
{	
	protected $_storeIds;
	
	public function toOptionArray()
    {
    	$store_array = array();
		
		//Get Websites
		$websites = Mage::app()->getWebsites();
		
		//For each website
		foreach ($websites as $website)
		{
			//Get Store groups
			foreach ($website->getGroups() as $group)
			{
				//For each Store
				foreach ($this->getStores($group) as $store)
				{
					$store_array[$store->getId()] = $website->getName()." -> ".$group->getName()." -> ".$store->getName();
				}
			}						
		}	
		return $store_array;		
    }
	
    public function getStores($group)
    {
        if (!$group instanceof Mage_Core_Model_Store_Group) {
            $group = Mage::app()->getGroup($group);
        }
        $stores = $group->getStores();
        if ($storeIds = $this->getStoreIds()) {
            foreach ($stores as $storeId => $store) {
                if (!in_array($storeId, $storeIds)) {
                    unset($stores[$storeId]);
                }
            }
        }
        return $stores;
    }	
	
    public function setStoreIds($storeIds)
    {
        $this->_storeIds = $storeIds;
        return $this;
    }

    public function getStoreIds()
    {
        return $this->_storeIds;
    }	
}
?>