<?php
class Netresearch_Magebid_Model_Session extends Mage_Core_Model_Session_Abstract
{
    public function __construct()
    {
        $namespace = 'magebid';
        $this->init($namespace);
    }
}
?>
