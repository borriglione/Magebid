<?php
class Netresearch_Magebid_Block_Adminhtml_Templates_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magebid';
		
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml_templates';

        if( $this->getRequest()->getParam($this->_objectId) ) {
            $magebidData = Mage::getModel('magebid/templates')
                ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('frozen_magebid', $magebidData);
        }
    }

    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Edit Element '%s'",
               $this->htmlEscape(Mage::registry('frozen_magebid')->getContentName()));
    }
}
