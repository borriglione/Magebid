<?php
/**
 * Netresearch_Magebid_Model_Auction_Type
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
