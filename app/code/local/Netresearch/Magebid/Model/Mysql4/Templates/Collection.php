<?php
class Netresearch_Magebid_Model_Mysql4_Templates_Collection extends Varien_Data_Collection_Db
{
    protected $_magebidTable;

    public function __construct()
    {
        $resources = Mage::getSingleton('core/resource');
        parent::__construct($resources->getConnection('magebid_read'));
        $this->_magebidTable = $resources->getTableName('magebid/templates');
        $this->_select->from(
        		array('magebid_templates'=>$this->_magebidTable),
 		       	array('*')
        		);
        $this->setItemObjectClass(Mage::getConfig()->getModelClassName('magebid/templates'));
    }
	
	public function toOptionArray()
	{
		return parent::_toOptionArray('magebid_templates_id','content_name');
	}	
}
?>