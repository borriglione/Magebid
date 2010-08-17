<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tabs
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();		
        $this->setId('magebid_export_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magebid')->__('Export'));
    }

    /**
     * Before HTML
     *
     * @return object
     */	
    protected function _beforeToHtml()
    {
        $this->addTab('profile', array(
            'label'     => Mage::helper('magebid')->__('Auction Details'),
            'title'     => Mage::helper('magebid')->__('Auction Details'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_profile')->toHtml(),
            'active'    => true,
        ));

        $this->addTab('payment', array(
            'label'     => Mage::helper('magebid')->__('Payment Methods'),
            'title'     => Mage::helper('magebid')->__('Payment Methods'),
   			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_payment')->toHtml(),
        ));
		
        $this->addTab('shipping', array(
            'label'     => Mage::helper('magebid')->__('Shipping Methods'),
            'title'     => Mage::helper('magebid')->__('Shipping Methods'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_shipping')->toHtml(),
        ));			
		
        $this->addTab('category', array(
            'label'     => Mage::helper('magebid')->__('Categories'),
            'title'     => Mage::helper('magebid')->__('Categories'),
			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_category')->toHtml(),
            'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
            'class'     => 'ajax',			
        ));				
	
        $this->addTab('policy', array(
            'label'     => Mage::helper('magebid')->__('Policies'),
            'title'     => Mage::helper('magebid')->__('Policies'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_policy')->toHtml(),
        ));			
		
        $this->addTab('layout', array(
            'label'     => Mage::helper('magebid')->__('Layout'),
            'title'     => Mage::helper('magebid')->__('Layout'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_layout')->toHtml(),
        ));	
		
        $this->addTab('product', array(
            'label'     => Mage::helper('magebid')->__('Selected Products'),
            'title'     => Mage::helper('magebid')->__('Selected Products'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_product')->toHtml(),
        ));				

        return parent::_beforeToHtml();
    }
}