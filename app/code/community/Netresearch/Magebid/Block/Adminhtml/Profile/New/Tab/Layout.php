<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Profile_New_Tab_Layout
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Profile_New_Tab_Layout extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		

		$yes_no_types = Mage::getSingleton('magebid/profile')->getYesNoTypes();
		
		$fieldset = $form->addFieldset('edit_magebid_layout', array('legend' => Mage::helper('magebid')->__('Layout')));
		
        $fieldset->addField('is_image', 'select', array(
            'name'      => 'is_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('With Image'),
            'label'     => Mage::helper('magebid')->__('With Image'),
			'required'	=> true,
        ));	
		
        $fieldset->addField('is_galery_image', 'select', array(
            'name'      => 'is_galery_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('Galery Listing Image'),
            'label'     => Mage::helper('magebid')->__('Galery Listing Image'),
			'required'	=> true,
        ));	
		
        $fieldset->addField('hit_counter', 'select', array(
            'name'      => 'hit_counter',
            'title'     => Mage::helper('magebid')->__('Hit Counter Style'),
            'label'     => Mage::helper('magebid')->__('Hit Counter Style'),
			'values'	=> Mage::getSingleton('magebid/profile')->getHitCounterStyles(),
			'required'	=> true,
        ));			

		
        $fieldset->addField('header_templates_id', 'select', array(
            'name'      => 'header_templates_id',
            'title'     => Mage::helper('magebid')->__('Header Template'),
            'label'     => Mage::helper('magebid')->__('Header Template'),
			'values'	=> Mage::getSingleton('magebid/templates')->getAllTemplatesOptions('header'),
			'required'	=> true,
        ));									
		
        $fieldset->addField('main_templates_id', 'select', array(
            'name'      => 'main_templates_id',
            'title'     => Mage::helper('magebid')->__('Main Template'),
            'label'     => Mage::helper('magebid')->__('Main Template'),
			'values'	=> Mage::getSingleton('magebid/templates')->getAllTemplatesOptions('main'),
			'required'	=> true,
        ));				
		
        $fieldset->addField('footer_templates_id', 'select', array(
            'name'      => 'footer_templates_id',
            'title'     => Mage::helper('magebid')->__('Footer Template'),
            'label'     => Mage::helper('magebid')->__('Footer Template'),
			'values'	=> Mage::getSingleton('magebid/templates')->getAllTemplatesOptions('footer'),	
			'required'	=> true,
        ));	
		
        /*
        $fieldset->addField('listing_enhancement', 'multiselect', array(
            'name'=>'listing_enhancement',
            'title'     => Mage::helper('magebid')->__('Listing Enhancement'),
            'label'     => Mage::helper('magebid')->__('Listing Enhancement'),				
            'values'	=> Mage::getSingleton('magebid/profile')->getListingEnhancements(),
        ));*/
		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>