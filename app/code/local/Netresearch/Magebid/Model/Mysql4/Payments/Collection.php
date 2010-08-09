<?php
class Netresearch_Magebid_Model_Mysql4_Payments_Collection extends Varien_Data_Collection_Db
{
    protected $_magebidTable;

    public function __construct()
    {
        $resources = Mage::getSingleton('core/resource');
        parent::__construct($resources->getConnection('magebid_read'));
        $this->_magebidTable = $resources->getTableName('magebid/payments');
        $this->_select->from(
        		array('magebid_payment_methods'=>$this->_magebidTable),
 		       	array('*')
        		);
        $this->setItemObjectClass(Mage::getConfig()->getModelClassName('magebid/payments'));
    }
}
?>