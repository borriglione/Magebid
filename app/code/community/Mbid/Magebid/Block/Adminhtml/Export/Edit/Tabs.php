<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Export_Edit_Tabs
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Export_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
            'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_category')->toHtml(),
            'class'     => 'ajax',			
        ));		        
		
        $this->addTab('store_category', array(
            'label'     => Mage::helper('magebid')->__('Store Categories'),
            'title'     => Mage::helper('magebid')->__('Store Categories'),
            'url'       => $this->getUrl('*/*/storeCategories', array('_current' => true)),
			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_store_category')->toHtml(),
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