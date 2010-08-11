<?php

class Netresearch_Magebid_Adminhtml_Export_MainController extends Mage_Adminhtml_Controller_Action
{   
    protected $_module = 'magebid';
    protected $_model  = 'export';
	
    /*
	public function indexAction()
    {
        $this->loadLayout();	
        $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_auction_main', 'auction'));
        $this->renderLayout();
    }
    */
	   
    /*
     * Select Profile
     * 
     * 
     * */
    public function newAction()
    {
		$ids = $this->getRequest()->getParam('product');
		$simple_products = array();
		$simple_products_form = array();		
		
		if($ids[0]=="") {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magebid')
			    ->__('Please select at least one simple product')
		    );
			$this->_redirectReferer();
        }
		else
		{
            try 
			{
                foreach ($ids as $id)
				{
					$product = Mage::getModel('catalog/product')->load($id);
					if ($product->getTypeId()=='simple')
					{
						$simple_products[] = $id;						
					} 
                }	
				
				if (count($simple_products)==0)	
				{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magebid')
					    ->__('Please select at least one simple product')
				    );
					$this->_redirectReferer();					
				}		
           } 
			catch (Exception $e)
			{
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }        

		Mage::getSingleton('magebid/session')->setData('selected_products',$simple_products);

        $this->loadLayout();				
        $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_export_new'));
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_export_new_tabs'));
        $this->renderLayout();		
    }		
	
	
	/*
	 * Load Profile
	 * Prepare Auction Preparation Form
	 * 
	 * */
    public function massPrepareAction()
    {
        //Get profile_id		
		if ($this->getRequest()->getParam('profile'))
		{
			$profile_id = $this->getRequest()->getParam('profile');
			Mage::getSingleton('magebid/session')->setData('selected_profile',$profile_id);
		}
		else
		{
			$profile_id = Mage::getSingleton('magebid/session')->getSelectedProfile();
		}		
		
		//Register Block Values        
		Mage::register('profile_id', $profile_id);		

		//Render Layout
        $this->loadLayout();				
        $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_export_edit'));

        if (!Mage::app()->isSingleStoreMode() && ($switchBlock = $this->getLayout()->getBlock('store_switcher'))) {
            $switchBlock->setDefaultStoreName(Mage::helper('magebid')->__('Default Values'))
                ->setSwitchUrl($this->getUrl('*/*/*', array('_current'=>true, 'active_tab'=>null, 'tab' => null, 'store'=>null)));
        }		
		
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_export_edit_tabs'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();		
    }		
	
    
    /*
     * 
     * Prepare Auctions
     */
	public function prepareAllAction()
	{		
		$selected_products = Mage::getSingleton('magebid/session')->getSelectedProducts();
		$ebay_settings = $this->getRequest()->getParams();		
		
		if (is_array($selected_products))
		{
            try 
			{
			    foreach ($selected_products as $id)
				{					
					//exit(Mage_Tax_Model_Config::CONFIG_XML_PATH_SHIPPING_INCLUDES_TAX);
					
					//$prod = Mage::getModel('catalog/product')->load($id);
					//$price = Mage::helper('tax')->getPrice($prod, 100, false, null,null,null,null,true);
					//echo $price;
					//exit();
					
					$export_model = Mage::getModel('magebid/export');
					$export_model->setEbaySettings($ebay_settings);					
					$export_model->setProduct($id);
					$export_model->prepareAuction();
                }				
            } 
			catch (Exception $e)
			{
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }			
		}		
		
		
		$this->getResponse()->setRedirect($this->getUrl('magebid/adminhtml_auction_main/'));
	}	
	
    /**
     * Get categories fieldset block
     *
     */
    public function categoriesAction()
    {        
		
		if( Mage::getSingleton('magebid/session')->getSelectedProfile()) {
            $magebidData = Mage::getModel('magebid/profile')
                ->load(Mage::getSingleton('magebid/session')->getSelectedProfile());
            Mage::register('frozen_magebid', $magebidData);
        }     
		
		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_category')->toHtml()
        );
    }	
	
    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_export_edit_tab_category')
                ->getEbayChildTreeJson($this->getRequest()->getParam('category'))
        );
    }
    
    public function categoryFeaturesJsonAction()
    {
    	$ebay_category_id = $this->getRequest()->getParam('category_id', false);
    	$conditions = Mage::getModel('magebid/import_category_features')->getAvailableConditions($ebay_category_id);
        $this->getResponse()->setBody(Zend_Json::encode($conditions));	
    }      
}

?>