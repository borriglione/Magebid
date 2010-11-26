<?php
/**
 * Mbid_Magebid_Model_Mysql4_Import_Category_Features_Collection
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Mysql4_Import_Category_Features_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/import_category_features');
	}	

    /**
     * Defining value and label for option-select-boxes
     *
     * @return array
     */	    	
	public function toOptionArray()
	{
		return parent::_toOptionArray('value_id','value_display_name');
	}	
}
?>