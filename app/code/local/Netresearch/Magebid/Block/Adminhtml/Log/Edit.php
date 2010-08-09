<?php
class Netresearch_Magebid_Block_Adminhtml_Log_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magebid';		
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml_log';

        if( $this->getRequest()->getParam($this->_objectId) ) {
            $magebidData = Mage::getModel('magebid/log')
                ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('frozen_magebid', $magebidData);
        }
        
		$this->_removeButton('reset'); 
		$this->_removeButton('save');        
    }

    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Edit Element '%s'",
               $this->htmlEscape(Mage::registry('frozen_magebid')->getTitle()));
    }
}
