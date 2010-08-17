<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Shipping
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Shipping extends Mage_Adminhtml_Block_Widget_Form
{	
    /**
     * Prepare Form
     *
     * @return object
     */	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('shipping_');
		
		$disabled = true;
		
		$auction = $form->addFieldset('auction_shipping_form', array('legend'=>Mage::helper('magebid')->__('Shipping')));

        $auction->addField('shipping_method', 'text', array(
            'label' => Mage::helper('magebid')->__('Shipping Method'),
			'disabled'	=> $disabled,
        ));	  	
		
        $auction->addField('shipping_cost', 'text', array(
            'label' => Mage::helper('magebid')->__('Shipping Cost'),
			'disabled'	=> $disabled,
        ));	  
       
        $auction->addField('shipping_add_cost', 'text', array(
            'label' => Mage::helper('magebid')->__('Add shipping cost'),
			'disabled'	=> $disabled,
        ));	  
						
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
