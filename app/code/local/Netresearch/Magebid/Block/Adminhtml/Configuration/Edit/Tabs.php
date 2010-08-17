<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Transaction_Edit
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();		
        $this->setId('magebid_configuration_edit_tabs');
        $this->setDestElementId('configuration_form');
        $this->setTitle(Mage::helper('magebid')->__('Configuration'));        
    }

    /**
     * Before HTML
     *
     * @return object
     */	
    protected function _beforeToHtml()
    {
        $active_tab = Mage::registry('active_tab');		
               
		$this->addTab('shipping', array(
            'label'     => Mage::helper('magebid')->__('Shipping Methods'),
            'title'     => Mage::helper('magebid')->__('Shipping Methods'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_shipping')->toHtml(),
			'active'    => ($active_tab=='shipping') ? true : false,
        ));	    
		
		$this->addTab('payment', array(
            'label'     => Mage::helper('magebid')->__('Payment Methods'),
            'title'     => Mage::helper('magebid')->__('Payment Methods'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_payment')->toHtml(),
			'active'	=> ($active_tab=='payment') ? true : false,
        ));	  		
		    
		$this->addTab('category', array(
            'label'     => Mage::helper('magebid')->__('Categories'),
            'title'     => Mage::helper('magebid')->__('Categories'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_category')->toHtml(),
			'active'	=> ($active_tab=='category') ? true : false,
        ));	  
		
		$this->addTab('store_category', array(
            'label'     => Mage::helper('magebid')->__('Store Categories'),
            'title'     => Mage::helper('magebid')->__('Store Categories'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_store_category')->toHtml(),
			'active'	=> ($active_tab=='store_category') ? true : false,
        ));	  	

		$this->addTab('category_features', array(
            'label'     => Mage::helper('magebid')->__('Category Features'),
            'title'     => Mage::helper('magebid')->__('Category Features'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_categoryFeatures')->toHtml(),
			'active'	=> ($active_tab=='category') ? true : false,
        ));	          
		
		$this->addTab('policy', array(
            'label'     => Mage::helper('magebid')->__('Return Policies'),
            'title'     => Mage::helper('magebid')->__('Return Policies'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_policy')->toHtml(),
			'active'	=> ($active_tab=='policy') ? true : false,
        ));	  	
		
		$this->addTab('mapping', array(
            'label'     => Mage::helper('magebid')->__('Mappings'),
            'title'     => Mage::helper('magebid')->__('Mappings'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_mapping')->toHtml(),
			'active'	=> ($active_tab=='mapping') ? true : false,
        ));	 	
        
        
		$this->addTab('dailyLog', array(
            'label'     => Mage::helper('magebid')->__('Daily Log'),
            'title'     => Mage::helper('magebid')->__('Daily Log'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_daily_log')->toHtml(),
			'active'	=> ($active_tab=='dailyLog') ? true : false,
        ));	 	        
		 						
        return parent::_beforeToHtml();
    }
	
}