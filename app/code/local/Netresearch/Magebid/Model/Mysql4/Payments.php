<?php
class Netresearch_Magebid_Model_Mysql4_Payments extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/payments/', 'magebid_payment_methods_id');
    }	
}
?>
