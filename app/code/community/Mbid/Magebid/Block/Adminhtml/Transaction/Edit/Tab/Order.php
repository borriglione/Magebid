<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Order
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Order extends Mage_Adminhtml_Block_Widget_Form
{	
    /**
     * Prepare Form
     *
     * @return object
     */	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('order_');
		
		$disabled = true;
		
		$yes_no_types = Mage::getSingleton('magebid/profile')->getYesNoTypes();
					
		$auction = $form->addFieldset('transaction_order_form', array('legend'=>Mage::helper('magebid')->__('Feedback')));
		
        $auction->addField('order_created', 'select', array(
            'label' => Mage::helper('magebid')->__('Magento Order created'),
			'disabled'	=> $disabled,
			'values'   => $yes_no_types,
        ));	  
        
        $auction->addField('order_id', 'text', array(
            'label' => Mage::helper('magebid')->__('Magento Order ID'),
			'disabled'	=> $disabled, 
        ));	 
		
        $auction->addField('ebay_order_id', 'text', array(
            'label' => Mage::helper('magebid')->__('eBay Order ID'),
			'disabled'	=> $disabled,
        ));	 
        
        $auction->addField('ebay_order_status', 'text', array(
            'label' => Mage::helper('magebid')->__('eBay Order Status'),
			'disabled'	=> $disabled,
        ));	 
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
