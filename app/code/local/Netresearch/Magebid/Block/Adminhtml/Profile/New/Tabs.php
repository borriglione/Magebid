<?php
class Netresearch_Magebid_Block_Adminhtml_Profile_New_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();		
        $this->setId('magebid_profile_new_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magebid')->__('Profile'));
    }
	
	

    protected function _beforeToHtml()
    {
        $this->addTab('profile', array(
            'label'     => Mage::helper('magebid')->__('Profile Details'),
            'title'     => Mage::helper('magebid')->__('Profile Details'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_profile_new_tab_profile')->toHtml(),
            'active'    => true,
        ));

        $this->addTab('payment', array(
            'label'     => Mage::helper('magebid')->__('Payment Methods'),
            'title'     => Mage::helper('magebid')->__('Payment Methods'),
   			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_profile_new_tab_payment')->toHtml(),
        ));
		
        $this->addTab('shipping', array(
            'label'     => Mage::helper('magebid')->__('Shipping Methods'),
            'title'     => Mage::helper('magebid')->__('Shipping Methods'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_profile_new_tab_shipping')->toHtml(),
        ));		

        $this->addTab('category', array(
            'label'     => Mage::helper('magebid')->__('Categories'),
            'title'     => Mage::helper('magebid')->__('Categories'),
            'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
            'class'     => 'ajax',			
        ));	        
		
        $this->addTab('store_category', array(
            'label'     => Mage::helper('magebid')->__('Store Categories'),
            'title'     => Mage::helper('magebid')->__('Store Categories'),
            'url'       => $this->getUrl('*/*/storeCategories', array('_current' => true)),
            'class'     => 'ajax',			
        ));		        

        $this->addTab('policy', array(
            'label'     => Mage::helper('magebid')->__('Policies'),
            'title'     => Mage::helper('magebid')->__('Policies'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_profile_new_tab_policy')->toHtml(),
        ));		
		
        $this->addTab('layout', array(
            'label'     => Mage::helper('magebid')->__('Layout'),
            'title'     => Mage::helper('magebid')->__('Layout'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_profile_new_tab_layout')->toHtml(),
        ));	
		
        return parent::_beforeToHtml();
    }
}