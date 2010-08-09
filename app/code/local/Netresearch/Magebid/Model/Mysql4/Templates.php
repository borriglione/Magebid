<?php
class Netresearch_Magebid_Model_Mysql4_Templates extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/templates', 'magebid_templates_id');
    }
}
?>
