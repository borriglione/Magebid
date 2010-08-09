<?php
class Netresearch_Magebid_Block_Adminhtml_Export_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/massPrepare'),
            'method'    => 'post'
        ));	
		
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();       
    }
}
