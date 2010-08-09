<?php
class Netresearch_Magebid_Model_Mysql4_Import_Shipping extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/import_shipping', 'magebid_import_shipping_methods_id');
    }	
}
?>
