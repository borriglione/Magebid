<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Transaction_Collection
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Mysql4_Transaction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/transaction');
	}	
	
    /**
     * Manipulation SQL: for every Transaction Collection, Load the Transaction-User-Data as well
     *
     * @return void
     */		
    public function joinFields()
    {
		$this->getSelect()
            ->join(
                array('mtu' => $this->getTable('magebid/transaction_user')), 
                'mtu.magebid_transaction_id = main_table.magebid_transaction_id');
    }	
}
?>