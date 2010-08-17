<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Profile_New_Tab_Profile
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Profile_New_Tab_Profile extends Mage_Adminhtml_Block_Widget_Form
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
		$yes_no_types = Mage::getSingleton('magebid/profile')->getYesNoTypes();
		
        $fieldset = $form->addFieldset('new_magebid', array('legend' => Mage::helper('magebid')->__('Profile Details')));
		
        $fieldset->addField('profile_name', 'text', array(
            'name'      => 'profile_name',
            'title'     => Mage::helper('magebid')->__('Profile Name'),
            'label'     => Mage::helper('magebid')->__('Profile Name'),
            'required'  => true,
        ));			
		
        $fieldset->addField('start_price', 'text', array(
            'name'      => 'start_price',
            'title'     => Mage::helper('magebid')->__('Start price'),
            'label'     => Mage::helper('magebid')->__('Start price'),
			'note'		=> Mage::helper('magebid')->__('Absolute price (199), percetage (+10% / -10%), or absolute reduction (+5,-5)'),			
        ));		
		
        $fieldset->addField('fixed_price', 'text', array(
            'name'      => 'fixed_price',
            'title'     => Mage::helper('magebid')->__('Fixed price'),
            'label'     => Mage::helper('magebid')->__('Fixed price'),
			'note'		=> Mage::helper('magebid')->__('Absolute price (199), percetage (+10% / -10%), or absolute reduction (+5,-5)'),			
        ));		
		
        $fieldset->addField('quantity', 'text', array(
            'name'      => 'quantity',
            'title'     => Mage::helper('magebid')->__('Quantity'),
            'label'     => Mage::helper('magebid')->__('Quantity'),
			'required'	=> true,
			'value'		=> 1	
        ));		
		
        $fieldset->addField('country', 'select', array(
            'name'      => 'country',
            'title'     => Mage::helper('magebid')->__('Country'),
            'label'     => Mage::helper('magebid')->__('Country'),
			'required'	=> true,
			'value'		=> 'DE',	
			'values'	=> Mage::app()->getLocale()->getCountryTranslationList(),			
        ));	
		
        $fieldset->addField('location', 'text', array(
            'name'      => 'location',
            'title'     => Mage::helper('magebid')->__('Location'),
            'label'     => Mage::helper('magebid')->__('Location'),
			'required'	=> true,
			'value'		=> 'Leipzig'
        ));				
		
        $fieldset->addField('currency', 'select', array(
            'name'      => 'currency',
            'title'     => Mage::helper('magebid')->__('Currency'),
            'label'     => Mage::helper('magebid')->__('Currency'),
			'required'	=> true,
			'value'		=> 'EUR',
			'values'	=> Mage::getSingleton('magebid/configuration')->getAvailableCurrencyCodes(),
        ));		
		
        $fieldset->addField('use_tax_table', 'select', array(
            'name'      => 'use_tax_table',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('Use Tax Table'),
            'label'     => Mage::helper('magebid')->__('Use Tax Table'),
			'required'	=> true,
        ));		
		
        $fieldset->addField('vat_percent', 'select', array(
            'name'      => 'vat_percent',
        	'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('Enable Product Tax'),
            'label'     => Mage::helper('magebid')->__('Enable Product Tax'),
       		'note'		=> Mage::helper('magebid')->__('Tax-rate of the Magento Product'),	
        	'required'	=> true,
        ));										
		
        $fieldset->addField('duration', 'text', array(
            'name'      => 'duration',
            'title'     => Mage::helper('magebid')->__('Duration'),
            'label'     => Mage::helper('magebid')->__('Duration'),
			'required'	=> true,	
			'value'		=> 7,
			'note'		=> Mage::helper('magebid')->__('Days'),		
        ));	
		
        $fieldset->addField('dispatch_time', 'text', array(
            'name'      => 'dispatch_time',
            'title'     => Mage::helper('magebid')->__('Dispatch Time'),
            'label'     => Mage::helper('magebid')->__('Dispatch Time'),
			'required'	=> true,	
			'note'		=> Mage::helper('magebid')->__('Days'),			
        ));	
		
        $fieldset->addField('is_image', 'select', array(
            'name'      => 'is_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('With Image'),
            'label'     => Mage::helper('magebid')->__('With Image'),
			'required'	=> true,
        ));		
		
        $fieldset->addField('magebid_auction_type_id', 'select', array(
            'name'      => 'magebid_auction_type_id',
            'title'     => Mage::helper('magebid')->__('Auction Type'),
            'label'     => Mage::helper('magebid')->__('Auction Type'),
			'values'	=> Mage::getSingleton('magebid/auction_type')->getAllAuctionTypesOptions(),	
			'required'	=> true,
        ));				
        
        $fieldset->addField('condition_id', 'select', array(
            'name'      => 'condition_id',
            'title'     => Mage::helper('magebid')->__('Condition'),
            'label'     => Mage::helper('magebid')->__('Condition'),
			'required'	=> false,
			'note'		=> Mage::helper('magebid')->__('Please select a category to choose this value'),
        ));	           
				
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>