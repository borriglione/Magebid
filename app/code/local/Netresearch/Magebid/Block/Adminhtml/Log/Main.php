<?php
class Netresearch_Magebid_Block_Adminhtml_Log_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_controller = 'adminhtml_log_main';
      	$this->_headerText = Mage::helper('magebid')->__('Magebid Log');
      	
      	$this->_removeButton('add');
    }
}
?>