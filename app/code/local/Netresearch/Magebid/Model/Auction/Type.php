<?php
class Netresearch_Magebid_Model_Auction_Type extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('magebid/auction_type');
    }	
	
	function getAllAuctionTypesOptions()
	{
		$collection = parent::getCollection();	
		$collection = $collection->toOptionArray();
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));
		return $collection;
	}
	

	
}
?>
