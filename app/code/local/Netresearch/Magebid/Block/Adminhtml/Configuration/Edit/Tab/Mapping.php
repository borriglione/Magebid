<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Mapping extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/mapping/index.phtml');
    }		
	
	public function getHeaderText()
	{
		return Mage::helper('magebid')->__('Mappings');
	}
	
	public function getSaveButton()
	{
		$button = array('name'      => 'import_mapping_settings',
                        'action'    => Mage::helper('adminhtml')->__('Save'),
						'clickAction' => 'importAction(this)');
		return $button;
	}
	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
		
		$fieldset_shipping = $form->addFieldset('edit_magebid_shipping_mapping', array('legend' => Mage::helper('magebid')->__('Mapping Shipping Services')));
		
        $fieldset_shipping->addField('shipping_method', 'text', array(
                'name'=>'shipping_method',
                'class'=>'requried-entry',
        ));

        $form->getElement('shipping_method')->setRenderer(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_shipping_mapping')
        );   	
		
		/*
		$fieldset_payment = $form->addFieldset('edit_magebid_payment_mapping', array('legend' => Mage::helper('magebid')->__('Mapping Payment Services')));
		
        $fieldset_payment->addField('payment_method', 'text', array(
                'name'=>'payment_method',
                'class'=>'requried-entry',
        ));	
		
        $form->getElement('payment_method')->setRenderer(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_payment_mapping')
        );   */			
				
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
	
	
}
?>