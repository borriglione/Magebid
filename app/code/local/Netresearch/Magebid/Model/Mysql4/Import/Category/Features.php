<?php
class Netresearch_Magebid_Model_Mysql4_Import_Category_Features extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct()
    {
        $this->_init('magebid/import_category_features', 'import_category_features_id');
    }		
    
    public function deleteAll()
    {
    	$write = $this->_getWriteAdapter();     
            
        $write->delete($this->getMainTable(),
                $write->quoteInto($this->getMainTable().'.key=?', 'Condition')
        );  
    }
}
?>
