<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Templates_Collection
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Mysql4_Templates_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/templates');
	}	
	
    /**
     * Defining value and label for option-select-boxes
     *
     * @return array
     */	
	public function toOptionArray()
	{
		return parent::_toOptionArray('magebid_templates_id','content_name');
	}	
}
?>