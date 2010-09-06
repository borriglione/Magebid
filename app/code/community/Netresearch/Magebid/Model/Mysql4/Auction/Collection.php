<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Auction_Collection
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Mysql4_Auction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/auction');
	}
	
    /**
     * Manipulating SQL: Join auction_details and auction_types
     *
     * @return void
     */	
    public function joinFields()
    {
		$this->getSelect()
		    ->join(
                array('mad' => $this->getTable('magebid/auction_detail')), 
                'mad.magebid_auction_detail_id = main_table.magebid_auction_detail_id')	
		    ->join(
                array('mat' => $this->getTable('magebid/auction_type')), 
                'mat.magebid_auction_type_id = main_table.magebid_auction_type_id');					
		//echo $this->getSelect()->__toString();
    }
	
	
}
?>