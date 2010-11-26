<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Shipping_Adress
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Shipping_Adress extends Mage_Adminhtml_Block_Widget_Form
{	
    /**
     * Prepare Form
     *
     * @return object
     */	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('shipping_adress_');
		
		$disabled = true;
		
					
		$auction = $form->addFieldset('auction_shipping_adress_form', array('legend'=>Mage::helper('magebid')->__('Shipping Adress')));

        $auction->addField('shipping_name', 'text', array(
            'label' => Mage::helper('magebid')->__('Name'),
			'disabled'	=> $disabled,
        ));	  	
		
        $auction->addField('shipping_street', 'text', array(
            'label' => Mage::helper('magebid')->__('Street'),
			'disabled'	=> $disabled,
        ));	  	
		
        $auction->addField('shipping_zip_code', 'text', array(
            'label' => Mage::helper('magebid')->__('Zip Code'),
			'disabled'	=> $disabled,
        ));	 
				
        $auction->addField('shipping_city', 'text', array(
            'label' => Mage::helper('magebid')->__('City'),
			'disabled'	=> $disabled,
        ));	  	
 					
        $auction->addField('shipping_country', 'text', array(
            'label' => Mage::helper('magebid')->__('Country'),
			'disabled'	=> $disabled,
        ));	  
       
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
