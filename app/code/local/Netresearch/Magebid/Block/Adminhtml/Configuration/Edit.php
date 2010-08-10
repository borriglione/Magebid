<?php

class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/index.phtml');
        $this->setTitle('Configuration');
        
        $this->_blockGroup = 'magebid';		
        $this->_mode = 'edit';       
    }
	
    public function initForm()
    {        
		$this->setChild('form',
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_form')
                ->initForm()
        );
		
        return $this;
    }	
}