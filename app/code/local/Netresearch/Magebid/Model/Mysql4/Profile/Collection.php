<?php
class Netresearch_Magebid_Model_Mysql4_Profile_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/profile');
	}
	
    public function joinFields()
    {
		$this->getSelect()
            ->join(
                array('mat' => $this->getTable('magebid/auction_type')), 
                'mat.magebid_auction_type_id = main_table.magebid_auction_type_id');
    }	
	
	public function toOptionArray()
	{
		return parent::_toOptionArray('magebid_profile_id','profile_name');
	}		
}
?>