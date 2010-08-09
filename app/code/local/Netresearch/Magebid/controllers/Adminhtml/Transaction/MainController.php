<?php

class Netresearch_Magebid_Adminhtml_Transaction_MainController extends Mage_Adminhtml_Controller_Action
{
    
	
	public function indexAction()
    {
        $this->loadLayout()
           ->_addContent($this->getLayout()
                           ->createBlock('magebid/adminhtml_transaction_main'))
            ->renderLayout();
    }
	
	public function editAction()
	{
	    $this->loadLayout();
	    $this->_addContent($this->getLayout()
	       ->createBlock('magebid/adminhtml_transaction_edit'));
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_transaction_edit_tabs'));		   
	    $this->renderLayout();
	}	
	
	public function deleteAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	
	    try {
	        Mage::getModel('magebid/transaction')->setId($magebidId)->load($magebidId)->delete();
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
	
	public function updateAllAction()
	{
        try 
		{		
			Mage::getModel('magebid/auction')->updateTransactions();
			
			Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Items were updated successfully'
                    )
                );			
		}	
		catch (Exception $e)
		{
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }		
		
		$this->indexAction();			
	}	
	
	public function massDeleteAction()
	{        
        $ids = $this->getRequest()->getParam('id');
        if(!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')
			    ->__('Please select at least one item')
		    );
        }
		else
		{
            try 
			{
                foreach ($ids as $id)
				{
					Mage::getModel('magebid/transaction')->setId($id)->delete();					
                }
				
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Items were deleted successfully'
                    )
                );
            } 
			catch (Exception $e)
			{
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
		
        $this->indexAction();			
	}		
				
}

?>