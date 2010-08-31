<?php
/**
 * Netresearch_Magebid_Model_System_Config_Source_Store
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_System_Config_Source_Store
{	
    /**
     * selected Magento Store View Ids
     * @var array
     */		
	protected $_storeIds;
	
    /**
     * Return the options for the store-selector
     *
     * @return array
     */		
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
	
    /**
     * Return the avaiable stores
     * 
     * @param int|object $group
     *
     * @return array
     */	  
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
	
    /**
     * set Storeview IDs
     * 
     * @param array $storeIds
     *
     * @return object
     */	   
    public function setStoreIds($storeIds)
    {
        $this->_storeIds = $storeIds;
        return $this;
    }

    /**
     * get Storeview IDs
     *
     * @return array
     */	   
    public function getStoreIds()
    {
        return $this->_storeIds;
    }	
}
?>