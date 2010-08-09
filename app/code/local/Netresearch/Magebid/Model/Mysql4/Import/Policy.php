<?php
class Netresearch_Magebid_Model_Mysql4_Import_Policy extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/import_policy', 'magebid_import_return_policy_id');
    }	
}
?>
