<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Shipping
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Shipping extends Mage_Adminhtml_Block_Widget_Form
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
