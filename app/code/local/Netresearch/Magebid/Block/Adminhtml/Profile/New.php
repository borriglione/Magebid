<?php
class Netresearch_Magebid_Block_Adminhtml_Profile_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
		
        $this->_blockGroup = 'magebid';
        $this->_mode = 'new';
        $this->_controller = 'adminhtml_profile';
    }

    public function getHeaderText()
    {
        return Mage::helper('magebid')->__('Add new profile');
    }
}
