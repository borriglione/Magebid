<?php
class Netresearch_Magebid_Adminhtml_Log_MainController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
        $this->loadLayout()
           ->_addContent($this->getLayout()
                           ->createBlock('magebid/adminhtml_log_main'))
            ->renderLayout();
			
    }
	
	public function editAction()
	{
	    $this->loadLayout();
	    $this->_addContent($this->getLayout()
	       ->createBlock('magebid/adminhtml_log_edit'));
	    $this->renderLayout();
	}
	
	public function deleteAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	
	    try {
	        Mage::getModel('magebid/log')->setId($magebidId)->delete();
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
	
	public function massDeleteAction()
	{        
        $ids = $this->getRequest()->getParam('id');
        if(!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magebid')
			    ->__('Please select at least one item')
		    );
        }
		else
		{
            try 
			{
                foreach ($ids as $id)
				{
					Mage::getModel('magebid/log')->setId($id)->delete();					
                }
				
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('magebid')->__('Items were deleted successfully'
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