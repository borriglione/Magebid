<?php
class Netresearch_Magebid_Block_Adminhtml_Templates_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_addButtonLabel = Mage::helper('magebid')->__('Add New');
        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_controller = 'adminhtml_templates_main';
      	$this->_headerText = Mage::helper('magebid')->__('Magebid Templates');
    }
}
?>