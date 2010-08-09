<?php
class Netresearch_Magebid_Model_Mysql4_Transaction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;
	protected $_joinFlags = array();

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/transaction');
	}	
	
    public function joinFields()
    {
		$this->getSelect()
            ->join(
                array('mtu' => $this->getTable('magebid/transaction_user')), 
                'mtu.magebid_transaction_id = main_table.magebid_transaction_id');
		/*
            ->join(
                array('mts' => $this->getTable('magebid/transaction_status')), 
                'mts.magebid_transaction_status_id = main_table.magebid_transaction_status_id');*/				
		//echo $this->getSelect()->__toString();
    }	
}
?>