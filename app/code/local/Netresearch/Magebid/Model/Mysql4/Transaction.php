<?php
class Netresearch_Magebid_Model_Mysql4_Transaction extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/transaction', 'magebid_transaction_id');
    }
	
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
		
		//Joins
        $select->join(
				array('mtu' => $this->getTable('magebid/transaction_user')),
				 $this->getMainTable().'.magebid_transaction_id = mtu.magebid_transaction_id');

				
		return $select;
	}	
	
	protected function _afterDelete(Mage_Core_Model_Abstract $object)
	{
			//Delete Transaction user
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_transaction_id = ?', $object->getId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/transaction_user'), $condition);							
	}		
	
	public function getDifferentOrders()
	{
		$select = $this->_getReadAdapter()
			->select()
			->from($this->getMainTable())  
			->columns('ebay_order_id')                        	
            ->where('order_created = ? AND ebay_order_status = ? AND ebay_order_id <> ?',0,Netresearch_Magebid_Model_Transaction::EBAY_ORDER_STATUS_COMPLETED,'')
            ->group('ebay_order_id');            
       
        return $this->_getReadAdapter()->fetchAll($select);	
	}
}
?>
