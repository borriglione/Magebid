<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Layout
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Layout extends Mage_Adminhtml_Block_Widget_Form
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
	
		$allowEdit = $this->getAllowEdit();
		if ($allowEdit) $disabled = false; else $disabled = true;	
		
		$yes_no_types = Mage::getSingleton('magebid/profile')->getYesNoTypes();
		
		$fieldset = $form->addFieldset('edit_magebid_layout', array('legend' => Mage::helper('magebid')->__('Layout')));
		
        $fieldset->addField('is_image', 'select', array(
            'name'      => 'is_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('With image'),
            'label'     => Mage::helper('magebid')->__('With image'),
			'required'	=> true,
			'disabled' => $disabled,	
        ));	
		
        $fieldset->addField('is_galery_image', 'select', array(
            'name'      => 'is_galery_image',
			'values'   => $yes_no_types,
            'title'     => Mage::helper('magebid')->__('Gallery Listing Image'),
            'label'     => Mage::helper('magebid')->__('Gallery Listing Image'),
			'required'	=> true,
			'disabled' => $disabled,
        ));	
		
        $fieldset->addField('hit_counter', 'select', array(
            'name'      => 'hit_counter',
            'title'     => Mage::helper('magebid')->__('Hit Counter'),
            'label'     => Mage::helper('magebid')->__('Hit Counter'),
			'values'	=> Mage::getSingleton('magebid/profile')->getHitCounterStyles(),
			'required'	=> true,
        ));		
		
        /*
        $fieldset->addField('listing_enhancement', 'multiselect', array(
            'name'=>'listing_enhancement',
            'title'     => Mage::helper('magebid')->__('Listing Enhancement'),
            'label'     => Mage::helper('magebid')->__('Listing Enhancement'),				
            'values'	=> Mage::getSingleton('magebid/profile')->getListingEnhancements(),
        ));				*/	
				
        $form->setValues(Mage::registry('frozen_magebid')->getData());		
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();		
	}
	
    /**
     * Return true if it is allowed to edit the data
     *
     * @return boolean
     */	
	public function getAllowEdit()
	{
		$role = Mage::registry('role');
		if ($role=='view') return false;
		return true;
	}		
}
?>