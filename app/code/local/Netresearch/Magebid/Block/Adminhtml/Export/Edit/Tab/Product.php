<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Product
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
		$store = Mage::app()->getStore();
		
		$yes_no_types = Mage::getSingleton('magebid/export')->getYesNoTypes();
		
		$fieldset = $form->addFieldset('edit_magebid_payment', array('legend' => Mage::helper('magebid')->__('Selected Products')));
		
        $fieldset->addField('products', 'multiselect', array(
            'title'     => Mage::helper('magebid')->__('Selected Products'),
            'label'     => Mage::helper('magebid')->__('Selected Products'),
			'values'	=> $this->getSelectedProducts(),
			'size'	=> '10',	

        ));	  
       
		 $form->setValues(Mage::registry('frozen_magebid')->getData());		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
	
    /**
     * Get the selected products for the export
     *
     * @return array
     */	
	public function getSelectedProducts()
	{
		//Get the selected products		
		$selected_products = Mage::getSingleton('magebid/session')->getSelectedProducts();		
		
		//Build product_array
		$simple_products_form = array();		
		if (count($selected_products)>0)
		{
			foreach ($selected_products as $id)
			{
						$product = Mage::getModel('catalog/product')->load($id);
						$simple_products_form[] = array('value' => $id,'label'=>$product->getName()." | ".$product->getSku());
	        }			
		}			
		return $simple_products_form;	
	}	
}
?>