<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Payment
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Payment extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('payment_');		
		$store = Mage::app()->getStore();
		
	    $auction = $form->addFieldset('auction_payment_methods', array('legend'=>Mage::helper('magebid')->__('Payment Methods')));
		
        $auction->addField('payment_method', 'text', array(
                'name'=>'payment_method',
                'class'=>'requried-entry',
                'value'=> '' //$product->getData('tier_price')
        ));

        $form->getElement('payment_method')->setRenderer(
            $this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tab_payment_method')
        );     		       
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
