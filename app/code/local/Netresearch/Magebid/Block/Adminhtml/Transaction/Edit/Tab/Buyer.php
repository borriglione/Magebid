<?php
class Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Buyer extends Mage_Adminhtml_Block_Widget_Form
{	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('buyer_');
		
		$disabled = true;
		
		$auction = $form->addFieldset('auction_buyer_form', array('legend'=>Mage::helper('magebid')->__('Buyer')));
		
        $auction->addField('buyer_ebay_user_id', 'text', array(
            'label' => Mage::helper('magebid')->__('eBay User Id'),
			'disabled'	=> $disabled,
        ));	  
		
        $auction->addField('buyer_email', 'text', array(
            'label' => Mage::helper('magebid')->__('eMail'),
			'disabled'	=> $disabled,
        ));	  		
		
        $auction->addField('registration_name', 'text', array(
            'label' => Mage::helper('magebid')->__('Name'),
			'disabled'	=> $disabled,
        ));	  	
		
        $auction->addField('registration_street', 'text', array(
            'label' => Mage::helper('magebid')->__('Street'),
			'disabled'	=> $disabled,
        ));	  	
		
        $auction->addField('registration_street_add', 'text', array(
            'label' => Mage::helper('magebid')->__('Street Add'),
			'disabled'	=> $disabled,
        ));	  	
		
        $auction->addField('registration_zip_code', 'text', array(
            'label' => Mage::helper('magebid')->__('Zip Code'),
			'disabled'	=> $disabled,
        ));	 
				
        $auction->addField('registration_city', 'text', array(
            'label' => Mage::helper('magebid')->__('City'),
			'disabled'	=> $disabled,
        ));	  	
 					
        $auction->addField('registration_country', 'text', array(
            'label' => Mage::helper('magebid')->__('Country'),
			'disabled'	=> $disabled,
        ));	  
       
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
