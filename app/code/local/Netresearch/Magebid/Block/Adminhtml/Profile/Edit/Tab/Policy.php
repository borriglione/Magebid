<?php
class Netresearch_Magebid_Block_Adminhtml_Profile_Edit_Tab_Policy extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
		
		$fieldset = $form->addFieldset('edit_magebid_policy', array('legend' => Mage::helper('magebid')->__('Policies')));
		
        $fieldset->addField('refund_option', 'select', array(
            'name'      => 'refund_option',
            'title'     => Mage::helper('magebid')->__('Refund Option'),
            'label'     => Mage::helper('magebid')->__('Refund Option'),
			'values'	=> Mage::getSingleton('magebid/import_policy')->getRefundOption(),			
			'required'	=> true,
        ));	
		
        $fieldset->addField('returns_accepted_option', 'select', array(
            'name'      => 'returns_accepted_option',
            'title'     => Mage::helper('magebid')->__('Returns Accepted'),
            'label'     => Mage::helper('magebid')->__('Returns Accepted'),
			'values'	=> Mage::getSingleton('magebid/import_policy')->getReturnsAcceptedOption(),
        ));			

        $fieldset->addField('returns_within_option', 'text', array(
            'name'      => 'returns_within_option',
            'title'     => Mage::helper('magebid')->__('Returns Within'),
            'label'     => Mage::helper('magebid')->__('Returns Within'),
			'note'		=> Mage::helper('magebid')->__('Days'),			
            'maxlength' => '50',
        ));			
		
        $fieldset->addField('returns_description', 'textarea', array(
            'name'      => 'returns_description',
            'title'     => Mage::helper('magebid')->__('Description'),
            'label'     => Mage::helper('magebid')->__('Description'),
            'style'     => 'width: 400px; height: 200px;',
            'required'  => true,
        ));			

		$form->setValues(Mage::registry('frozen_magebid')->getData());		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>