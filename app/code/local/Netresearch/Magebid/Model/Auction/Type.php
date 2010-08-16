<?php
/**
 * Netresearch_Magebid_Model_Auction_Type
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Auction_Type extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/auction_type');
    }	
	
    /**
     * Get all auction types for an option-select-box
     *
     * @return array
     */	
	function getAllAuctionTypesOptions()
	{
		$collection = parent::getCollection();	
		$collection = $collection->toOptionArray();
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));
		return $collection;
	}
	

	
}
?>
