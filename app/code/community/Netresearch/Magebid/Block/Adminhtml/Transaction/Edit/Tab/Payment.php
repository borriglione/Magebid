<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Payment
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Payment extends Mage_Adminhtml_Block_Widget_Form
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
		
		$disabled = true;
		
		$auction = $form->addFieldset('auction_payment_form', array('legend'=>Mage::helper('magebid')->__('Payment Method')));

        $auction->addField('payment_method', 'text', array(
            'label' => Mage::helper('magebid')->__('Payment Method'),
			'disabled'	=> $disabled,
        ));	  	
       
        $auction->addField('payment_status', 'text', array(
            'label' => Mage::helper('magebid')->__('Payment Status'),
			'disabled'	=> $disabled,
        ));	  		   
	   
        $auction->addField('payment_hold_status', 'text', array(
            'label' => Mage::helper('magebid')->__('Payment Hold Status'),
			'disabled'	=> $disabled,
        ));	  	
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
