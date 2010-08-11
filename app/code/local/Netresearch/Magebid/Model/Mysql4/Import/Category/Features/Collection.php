<?php
class Netresearch_Magebid_Model_Mysql4_Import_Category_Features_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;
	protected $_joinFlags = array();

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/import_category_features');
	}	

	public function toOptionArray()
	{
		return parent::_toOptionArray('value_id','value_display_name');
	}	
}
?>