<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Import_Policy_Collection
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Mysql4_Import_Policy_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/import_policy');
	}	

    /**
     * Defining value and label for option-select-boxes
     *
     * @return array
     */	    	
	public function transformToOptionArray($key,$value)
	{
		return parent::_toOptionArray($key,$value);
	}	
}
?>