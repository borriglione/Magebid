<?php
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Auction extends Mage_Adminhtml_Block_Widget_Form
{	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('auction_');
		
		$store = Mage::app()->getStore();

        $auction = $form->addFieldset('auction_form', array('legend'=>Mage::helper('magebid')->__('General Informations')));
	   
	   
	    if (Mage::registry('frozen_magebid')->getData('ebay_item_id')!="")
		{
	        $auction->addField('ebay_item_id', 'label', array(
	            'label' => Mage::helper('magebid')->__('eBay Auction Id'),
	        ));			
		}		

        $auction->addField('auction_name', 'label', array(
            'label' => Mage::helper('magebid')->__('Auction title'),
        ));	 
		
        $auction->addField('product_id', 'label', array(
            'label' => Mage::helper('magebid')->__('Product ID'),
        ));	   
	  
        $auction->addField('product_sku', 'label', array(
            'label' => Mage::helper('magebid')->__('Product SKU'),
        ));
		
        $auction->addField('status_name', 'label', array(
            'label' => Mage::helper('magebid')->__('eBay Status'),
        ));	
		
	    if (Mage::registry('frozen_magebid')->getData('last_updated')!="")
		{
	        $auction->addField('last_updated', 'label', array(
	            'label' => Mage::helper('magebid')->__('Last update'),
	        ));	  	
		}			 		
       
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
