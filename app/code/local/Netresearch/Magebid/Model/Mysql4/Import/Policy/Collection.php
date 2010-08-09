<?php
class Netresearch_Magebid_Model_Mysql4_Import_Policy_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;
	protected $_joinFlags = array();

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/import_policy');
	}	

	public function transformToOptionArray($key,$value)
	{
		return parent::_toOptionArray($key,$value);
	}	
}
?>