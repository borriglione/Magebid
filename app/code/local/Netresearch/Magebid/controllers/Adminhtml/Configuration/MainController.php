<?php

class Netresearch_Magebid_Adminhtml_Configuration_MainController extends Mage_Adminhtml_Controller_Action
{   
	public function indexAction()
    {
	    $this->loadLayout();
		
		//exit(get_class($this->getLayout()));
		
        if (!Mage::app()->isSingleStoreMode() && ($switchBlock = $this->getLayout()->getBlock('store_switcher'))) {
            $switchBlock->setDefaultStoreName(Mage::helper('magebid')->__('Default Store'))
                ->setSwitchUrl($this->getUrl('*/*/*', array('_current'=>true, 'active_tab'=>null, 'tab' => null, 'store'=>null)));
        }			
		
        $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_configuration_edit')->initForm());
        $this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tabs'));
		$this->renderLayout();  
    }
	
	public function saveAction()
	{
		$data = $this->getRequest()->getPost();	
		
		$active_tab = "shipping";		
		
		
		
		try
		{		   
			if (isset($data['task_action']))
			{
			    switch ($data['task_action'])
				{
					case 'import_shipping_methods':
						$this->_importShippingMethods();
						$active_tab = "shipping";
					break;		
					
					case 'import_payment_methods':
						$this->_importPaymentMethods();
						$active_tab = "payment";
					break;	
					
					case 'import_categories':
						$this->_importCategories();
						$active_tab = "category";
					break;		
					
					case 'import_store_categories':
						$this->_importStoreCategories();
						$active_tab = "store_category";
					break;														

					case 'import_category_features':
						$this->_importCategoryFeatures();
						$active_tab = "category_features";
					break;						
					
					case 'import_return_policies':
						$this->_importPolicies();
						$active_tab = "policy";
					break;		
					
					case 'import_mapping_settings':
						$this->_importMappings($data);
						$active_tab = "mapping";
					break;							
				}				
			}

			Mage::register('active_tab', $active_tab);	
	   }
	   catch (Exception $e)
	   {	 
	            Mage::getSingleton('adminhtml/session')
	            ->addError($e->getMessage());
	   }	   
	   $this->indexAction();
	}
	
	protected function _importShippingMethods()
	{
		$number_imported = Mage::getModel('magebid/import_shipping')->importEbayShippingMethods();
		Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('%d Shipping Methods were successfully imported',$number_imported));			
	}
	
	protected function _importPaymentMethods()
	{
		$number_imported = Mage::getModel('magebid/import_payment')->importEbayPaymentMethods();		
		Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('%d Payment Methods were successfully imported',$number_imported));			
	}	
	
	protected function _importCategories()
	{
		if ($number_imported = Mage::getModel('magebid/import_category')->importEbayCategories())
		{
			Mage::getSingleton('adminhtml/session')
		               ->addSuccess(Mage::helper('magebid')
		               ->__('%d Categories were successfully imported',$number_imported));				
		}		
	}	
	
	protected function _importStoreCategories()
	{		
		if ($number_imported = Mage::getModel('magebid/import_store_category')->importEbayStoreCategories())
		{			
			Mage::getSingleton('adminhtml/session')
		               ->addSuccess(Mage::helper('magebid')
		               ->__('%d Store Categories were successfully imported',$number_imported));				
		}
	}		
	
	protected function _importCategoryFeatures()
	{
		if (Mage::getModel('magebid/import_category_features')->importCategoryFeatures())
		{			
			Mage::getSingleton('adminhtml/session')
		               ->addSuccess(Mage::helper('magebid')
		               ->__(' Category Features were successfully imported'));				
		}	
	}
	
	protected function _importPolicies()
	{
		$number_imported = Mage::getModel('magebid/import_policy')->importEbayPolicies();
		Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Policies were successfully imported'));			
	}			
	
	protected function _importMappings($data)
	{
		Mage::getModel('magebid/mapping')->saveMapping($data);
		Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Mappings were saved'));		
	}

    public function categoriesAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_category_grid')->toHtml()
        );
    }	
	
    public function storeCategoriesAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_store_category_grid')->toHtml()
        );
    }		
	
    public function paymentsAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_payment_grid')->toHtml()
        );
    }	
	
    public function shippingsAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_shipping_grid')->toHtml()
        );
    }		
    
    public function dailyLogAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_daily_log_grid')->toHtml()
        );
    }	   
}
?>