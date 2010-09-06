<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Auction
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Auction extends Mage_Adminhtml_Block_Widget_Form
{	
    /**
     * Prepare Form
     *
     * @return object
     */	
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
		
        $auction->addField('magebid_ebay_status_id', 'select', array(
            'label' => Mage::helper('magebid')->__('eBay Status'),
			'values' => Mage::getSingleton('magebid/auction')->getEbayStatusOptions(),	
			'disabled' => true,	
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
