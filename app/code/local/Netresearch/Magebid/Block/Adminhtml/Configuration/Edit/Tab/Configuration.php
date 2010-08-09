<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Configuration extends Mage_Adminhtml_Block_Widget_Form
{	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('shipping_');		
		$fieldset = $form->addFieldset('cache_enable', array(
            'legend' => Mage::helper('magebid')->__('General Configuration')
        ));
       
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
