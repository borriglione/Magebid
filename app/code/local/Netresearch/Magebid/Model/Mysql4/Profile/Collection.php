<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Profile_Collection
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Mysql4_Profile_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/profile');
	}
	
    /**
     * Manipulating SQL: Join Auction Type Table
     *
     * @return void
     */	
    public function joinFields()
    {
		$this->getSelect()
            ->join(
                array('mat' => $this->getTable('magebid/auction_type')), 
                'mat.magebid_auction_type_id = main_table.magebid_auction_type_id');
    }	

    /**
     * Defining value and label for option-select-boxes
     *
     * @return array
     */	    
	public function toOptionArray()
	{
		return parent::_toOptionArray('magebid_profile_id','profile_name');
	}		
}
?>