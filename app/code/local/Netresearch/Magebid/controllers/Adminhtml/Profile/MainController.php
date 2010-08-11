<?php

class Netresearch_Magebid_Adminhtml_Profile_MainController extends Mage_Adminhtml_Controller_Action
{
    
	
	public function indexAction()
    {
        $this->loadLayout()
           ->_addContent($this->getLayout()
                           ->createBlock('magebid/adminhtml_profile_main'))
            ->renderLayout();
    }
	

    public function newAction() // Create new element
    {
		$this->loadLayout()
        ->_addContent($this->getLayout()
           ->createBlock('magebid/adminhtml_profile_new'));
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_profile_new_tabs'));	
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);	   
        $this->renderLayout();
    }     

    public function postAction() // Save element
    {		
         if ($data = $this->getRequest()->getPost()) {         	
            $magebid = Mage::getModel('magebid/profile')->setData($data);
            try {
                $magebid->save();
                Mage::getSingleton('adminhtml/session')
                     ->addSuccess(Mage::helper('magebid')
                     ->__('Item was successfully saved'));
                $this->getResponse()->setRedirect($this->getUrl('*/*/'));
                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')
                  ->addError($e->getMessage());
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
        return;        
    }
	

	public function editAction()
	{
	    $this->loadLayout();
	    $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_profile_edit'));
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_profile_edit_tabs'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);		
	    $this->renderLayout();
	}
	
	public function saveAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	    if ($data = $this->getRequest()->getPost())
		{
			//print_r($this->getRequest()->getParams());
			//exit();	       
		   
		    $magebid = Mage::getModel('magebid/profile')->load($magebidId)->addData($data);
			  
	        try {
	            $magebid->setId($magebidId)->save();
	
	            Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Item was saved successfully'));
				   
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $magebidId));
                    return;
                }				   
				   
	            $this->getResponse()->setRedirect($this->getUrl('*/*/'));
	            return;
	        } catch (Exception $e){	 
	            Mage::getSingleton('adminhtml/session')
	            ->addError($e->getMessage());
	        }
	    }
	    $this->_redirectReferer();
	}

	
	public function deleteAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	
	    try {
	        Mage::getModel('magebid/profile')->setId($magebidId)->load($magebidId)->delete();
	        Mage::getSingleton('adminhtml/session')
	           ->addSuccess(Mage::helper('magebid')
	              ->__('Item successfully deleted'));
	        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
	
	        return;
	    } catch (Exception $e){
	        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	    }
	
	    $this->_redirectReferer();
	}	
	

    /**
     * Get categories fieldset block
     *
     */
    public function categoriesAction()
    {        
		
		if( $this->getRequest()->getParam('id') ) {
            $magebidData = Mage::getModel('magebid/profile')
                ->load($this->getRequest()->getParam('id'));
            Mage::register('frozen_magebid', $magebidData);
        }     
		
		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_profile_edit_tab_category')->toHtml()
        );
    }	
	
    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_profile_edit_tab_category')
                ->getEbayChildTreeJson($this->getRequest()->getParam('category'))
        );
    }	
	
    public function storeCategoriesAction()
    {        
		
		if( $this->getRequest()->getParam('id') ) {
            $magebidData = Mage::getModel('magebid/profile')
                ->load($this->getRequest()->getParam('id'));
            Mage::register('frozen_magebid', $magebidData);
        }     
		
		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_profile_edit_tab_store_category')->toHtml()
        );
    }	
	
    public function storeCategoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_profile_edit_tab_store_category')
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