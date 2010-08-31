<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Feedback
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Feedback extends Mage_Adminhtml_Block_Widget_Form
{	
    /**
     * Prepare Form
     *
     * @return object
     */	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('feedback_');
		
		$disabled = true;
		
		$yes_no_types = Mage::getSingleton('magebid/profile')->getYesNoTypes();
					
		$auction = $form->addFieldset('transaction_feedback_form', array('legend'=>Mage::helper('magebid')->__('Feedback')));

        $auction->addField('payment_received', 'select', array(
            'label' => Mage::helper('magebid')->__('Payment received'),
			'disabled'	=> $disabled,
			'values'   => $yes_no_types,        
        ));	  	
		
        $auction->addField('shipped', 'select', array(
            'label' => Mage::helper('magebid')->__('Shipped'),
			'disabled'	=> $disabled,
			'values'   => $yes_no_types, 
        ));	  	
		
        $auction->addField('reviewed', 'select', array(
            'label' => Mage::helper('magebid')->__('Reviewed'),
			'disabled'	=> $disabled,
			'values'   => $yes_no_types, 
        ));	 
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
