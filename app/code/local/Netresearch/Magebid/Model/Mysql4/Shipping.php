<?php
class Netresearch_Magebid_Model_Mysql4_Shipping extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/shipping', 'magebid_shipping_methods_id');
    }
}
?>
