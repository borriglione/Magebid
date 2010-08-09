<?php
class Netresearch_Magebid_Model_Mysql4_Import_Payment extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/import_payment', 'magebid_import_payment_methods_id');
    }	
}
?>
