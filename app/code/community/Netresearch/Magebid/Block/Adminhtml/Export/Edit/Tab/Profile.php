<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Profile
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Profile extends Mage_Adminhtml_Block_Widget_Form
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
				
        $fieldset = $form->addFieldset('new_magebid', array('legend' => Mage::helper('magebid')->__('Auctiondetails')));
		
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
		
		$outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $fieldset->addField('start_date', 'date',array(
                'name'      =>    'start_date',
                'time'      =>    true,
                'format'    =>    $outputFormat,
           		'title'     => Mage::helper('magebid')->__('Start time'),
           		'label'     => Mage::helper('magebid')->__('Start time'),
                'image'     =>    $this->getSkinUrl('images/grid-cal.gif')
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
            'title'     => Mage::helper('magebid')->__('Dispatch time'),
            'label'     => Mage::helper('magebid')->__('Dispatch time'),
			'required'	=> true,	
			'note'		=> Mage::helper('magebid')->__('Days'),			
        ));				
		
        $fieldset->addField('is_image', 'select', array(
            'name'      => 'is_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('With image'),
            'label'     => Mage::helper('magebid')->__('With image'),
			'required'	=> true,
        ));		
		
        $fieldset->addField('magebid_auction_type_id', 'select', array(
            'name'      => 'magebid_auction_type_id',
            'title'     => Mage::helper('magebid')->__('Auction type'),
            'label'     => Mage::helper('magebid')->__('Auction type'),
			'values'	=> Mage::getSingleton('magebid/auction_type')->getAllAuctionTypesOptions(),	
			'required'	=> true,
			'value' 	=> 1
        ));	        
        
        $fieldset->addField('condition_id', 'select', array(
            'name'      => 'condition_id',
            'title'     => Mage::helper('magebid')->__('Condition'),
            'label'     => Mage::helper('magebid')->__('Condition'),
			'required'	=> false,
			'values'	=> Mage::getSingleton('magebid/import_category_features')->getAvailableConditions(Mage::registry('frozen_magebid')->getData('ebay_category_1')),
			'note'		=> Mage::helper('magebid')->__('Please select a category to choose this value'),
        ));	             
		
		$form->setValues(Mage::registry('frozen_magebid')->getData());
		
        $fieldset->addField('store', 'hidden', array(
            'name'      => 'store',
			'value'		=> $this->getStore(),
        ));	       
				
        $this->setForm($form);
        return parent::_prepareForm();	
	}
	
    /**
     * Get selected storeview
     *
     * @return int
     */	
	public function getStore()
	{
		//Set store Id
		if ($this->getRequest()->getParam('store'))
		{
			return $this->getRequest()->getParam('store');
		}
		else
		{
			return '0';
		}
			 		
	}
}
?>