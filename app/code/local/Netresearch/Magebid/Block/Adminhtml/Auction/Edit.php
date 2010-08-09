<?php

class Netresearch_Magebid_Block_Adminhtml_Auction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'magebid';		
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml_auction';

		

        if( $this->getRequest()->getParam($this->_objectId) )
		{
            //exit($this->getRequest()->getParam($this->_objectId));
			$magebidData = Mage::getModel('magebid/auction')->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('frozen_magebid', $magebidData);
        }
		
		
		
		//Set Role
		if ($magebidData->getMagebidEbayStatusId()>0)
		{
			$this->_removeButton('save');
			$this->_removeButton('reset');
			Mage::register('role','view');
		}
		else
		{
			Mage::register('role','edit');
	        $this->_addButton('saveandcontinue', array(
	            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
	            'onclick'   => 'saveAndContinueEdit()',
	            'class'     => 'save',
	        ), -100);	
			
	        $this->_formScripts[] = "
	            function saveAndContinueEdit(){
	                editForm.submit($('edit_form').action+'back/edit/');
	            }
	        ";					
		}
    }

    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Auction '%s'",
               $this->htmlEscape(Mage::registry('frozen_magebid')->getAuctionName()));
    }
}