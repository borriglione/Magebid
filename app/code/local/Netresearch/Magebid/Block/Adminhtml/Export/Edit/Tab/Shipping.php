<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Shipping
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Shipping extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
	
		$fieldset = $form->addFieldset('edit_magebid_shipping', array('legend' => Mage::helper('magebid')->__('Shipping Methods')));
		
        $fieldset->addField('shipping_method', 'text', array(
                'name'=>'shipping_method',
                //'class'=>'requried-entry',
                'value'=> '' //$product->getData('tier_price')
        ));

        $form->getElement('shipping_method')->setRenderer(
            $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_shipping_method')
        );   	
       
		 $form->setValues(Mage::registry('frozen_magebid')->getData());		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>