<?php
class Netresearch_Magebid_Model_Mysql4_Auction_Type_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;
	protected $_joinFlags = array();

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/auction_type');
	}	
	
	public function toOptionArray()
	{
		return parent::_toOptionArray('magebid_auction_type_id');
	}

}
?>