<?php
class Netresearch_Magebid_Model_Mysql4_Transaction_User_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;
	protected $_joinFlags = array();

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/transaction_user');
	}	
	
}
?>