<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Export_Edit_Tab_Payment
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Export_Edit_Tab_Payment extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
		
		$fieldset = $form->addFieldset('edit_magebid_payment', array('legend' => Mage::helper('magebid')->__('Payment Details')));
		
        $fieldset->addField('payment_method', 'text', array(
                'name'=>'payment_method',
                //'class'=>'requried-entry',
                'value'=> '' //$product->getData('tier_price')
        ));

        $form->getElement('payment_method')->setRenderer(
            $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_payment_method')
        );       
       
		 $form->setValues(Mage::registry('frozen_magebid')->getData());		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>