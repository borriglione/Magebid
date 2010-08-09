<?php

class Netresearch_Magebid_Adminhtml_Templates_MainController extends Mage_Adminhtml_Controller_Action
{
    
	
	public function indexAction()
    {
        $this->loadLayout()
           ->_addContent($this->getLayout()
                           ->createBlock('magebid/adminhtml_templates_main'))
            ->renderLayout();
			
    }
	

    public function newAction() // Create new element
    {

		$this->loadLayout()
        ->_addContent($this->getLayout()
           ->createBlock('magebid/adminhtml_templates_new'))
        ->renderLayout();
    }     

    public function postAction() // Save element
    {
        
         if ($data = $this->getRequest()->getPost()) {
            $magebid = Mage::getModel('magebid/templates')->setData($data);
            try {
                $magebid->save();
                Mage::getSingleton('adminhtml/session')
                     ->addSuccess(Mage::helper('magebid')
                     ->__('Item was successfully saved'));
                $this->getResponse()->setRedirect($this->getUrl('*/*/'));
                return;
            } catch (Exception $e){
                die($e->getMessage());
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
	    $this->_addContent($this->getLayout()
	       ->createBlock('magebid/adminhtml_templates_edit'));
	    $this->renderLayout();
	}
	
	public function saveAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	    if ($data = $this->getRequest()->getPost())
		{
			$magebid = Mage::getModel('magebid/templates')->load($magebidId)->addData($data);
			  
	        try {
	            $magebid->setId($magebidId)->save();
	
	            Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Content was saved successfully'));
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
	        Mage::getModel('magebid/templates')->setId($magebidId)->delete();
	        Mage::getSingleton('adminhtml/session')
	           ->addSuccess(Mage::helper('magebid')
	              ->__('Content successfully deleted'));
	        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
	
	        return;
	    } catch (Exception $e){
	        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	    }
	
	    $this->_redirectReferer();
	}	
	
}

?>