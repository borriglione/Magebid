<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Import_Category_Features
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Mysql4_Import_Category_Features extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/import_category_features', 'import_category_features_id');
    }		
    
    /**
     * Deletes all eBay Categories Features
     * 
     * @return void
     */	   
    public function deleteAll()
    {
    	$write = $this->_getWriteAdapter();     
            
        $write->delete($this->getMainTable(),
                $write->quoteInto($this->getMainTable().'.key=?', 'Condition')
        );  
    }
}
?>
