<?php
class Netresearch_Magebid_Block_Adminhtml_Profile_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_addButtonLabel = Mage::helper('magebid')->__('Add New');

        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_controller = 'adminhtml_profile_main';
    }
	
    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Profile List');		
    }
		
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('adminhtml/admin_profile_main_grid', 'auction.main.grid'));		
        return parent::_beforeToHtml();
    }	
}
?>