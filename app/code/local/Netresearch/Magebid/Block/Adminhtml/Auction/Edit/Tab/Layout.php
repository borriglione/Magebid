<?php
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Layout extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
		$store = Mage::app()->getStore();
	
		$allowEdit = $this->getAllowEdit();
		if ($allowEdit) $disabled = false; else $disabled = true;	
		
		$yes_no_types = Mage::getSingleton('magebid/profile')->getYesNoTypes();
		
		$fieldset = $form->addFieldset('edit_magebid_layout', array('legend' => Mage::helper('magebid')->__('Layout')));
		
        $fieldset->addField('is_galery_image', 'select', array(
            'name'      => 'is_galery_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('Gallery Listing Image'),
            'label'     => Mage::helper('magebid')->__('Gallery Listing Image'),
			'required'	=> true,
			'disabled' => $disabled,
        ));	
		
        $fieldset->addField('hit_counter', 'select', array(
            'name'      => 'hit_counter',
            'title'     => Mage::helper('magebid')->__('Hit Counter'),
            'label'     => Mage::helper('magebid')->__('Hit Counter'),
			'values'	=> Mage::getSingleton('magebid/profile')->getHitCounterStyles(),
			'required'	=> true,
        ));		
		
        $fieldset->addField('listing_enhancement', 'multiselect', array(
            'name'=>'listing_enhancement',
            'title'     => Mage::helper('magebid')->__('Listing Enhancement'),
            'label'     => Mage::helper('magebid')->__('Listing Enhancement'),				
            'values'	=> Mage::getSingleton('magebid/profile')->getListingEnhancements(),
        ));					
				
        $form->setValues(Mage::registry('frozen_magebid')->getData());		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();		
	}
	
	public function getAllowEdit()
	{
		$role = Mage::registry('role');
		if ($role=='view') return false;
		return true;
	}		
}
?>