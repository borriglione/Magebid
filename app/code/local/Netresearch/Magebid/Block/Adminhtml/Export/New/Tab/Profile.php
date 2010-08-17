<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_New_Tab_Profile
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Export_New_Tab_Profile extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();				

		$fieldset = $form->addFieldset('edit_profile', array('legend' => Mage::helper('magebid')->__('Select a Profile')));
		
        $fieldset->addField('profile', 'select', array(
            'name'      => 'profile',
            'title'     => Mage::helper('magebid')->__('Profile'),
            'label'     => Mage::helper('magebid')->__('Profile'),
			'values'	=> Mage::getModel('magebid/profile')->getAllProfileOptions(),
			'required'	=> true,	
        ));		
       
        $this->setForm($form);
        return parent::_prepareForm();	
	}
	
    /**
     * Return the selected Products for the export
     *
     * @return array
     */	
	public function getSelectedProducts()
	{
		return  Mage::registry('selected_products');	
	}	
}
?>