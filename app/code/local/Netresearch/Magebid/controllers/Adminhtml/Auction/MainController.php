<?php

class Netresearch_Magebid_Adminhtml_Auction_MainController extends Mage_Adminhtml_Controller_Action
{
    protected $_module = 'magebid';
    protected $_model  = 'auction';
	
	public function indexAction()
    {
        $magebid_ebay_status_id = $this->getRequest()->getParam('magebid_ebay_status_id', false);
		Mage::register('magebid_ebay_status_id', $magebid_ebay_status_id);	
		
		$this->loadLayout();				
        $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_auction_main', 'auction'));
        $this->renderLayout();		

    }
	
	public function editAction()
	{
	    $this->loadLayout();
	    $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_auction_edit'));
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tabs'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	    $this->renderLayout();
	}			
	
	public function deleteAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	
	    try {
	        Mage::getModel('magebid/auction')->setId($magebidId)->load($magebidId)->delete();
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
	
	
	public function saveAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
		
	    if ($data = $this->getRequest()->getPost())
		{
			$magebid = Mage::getModel('magebid/auction')->load($magebidId);
			  
	        try {
	            $magebid->addData($data)->save();
	
	            Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Item was edited successfully'));
				   
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
					Mage::getModel('magebid/auction')->setId($id)->delete();					
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
		
	
	public function updateallAction()
	{
        try 
		{		
			//Get Start/End Time
			//$from = Mage::getSingleton('magebid/configuration')->getLastSellerEvent();
			$from = Mage::getModel('magebid/auction')->getResource()->getOldestStartDate();
			$to = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');			
			
			//Make call
			//$events = Mage::getModel('magebid/ebay_items')->getLastSellerEvents($from,$to);
			$items = Mage::getModel('magebid/ebay_items')->getSellerList($from,$to);			
			
			//For every modified item
			foreach ($items as $item)
			{
				//$mapped_item = Mage::getModel('magebid/ebay_items')->getHandler()->mappingItem($item);							
				$auction = Mage::getModel('magebid/auction')->load($item['ebay_item_id'],'ebay_item_id');
				$auction->ebayUpdate($item);
			}					
               
			//Set Time for the this Update (only used for getSellerEvent)
			//Mage::getSingleton('magebid/configuration')->setLastSellerEvent($now);
			
			//Update all transactions
			Mage::getModel('magebid/auction')->updateTransactions();
			
			Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('magebid')->__('Auctions were updated successfully'
                    )
            );			
		}	
		catch (Exception $e)
		{
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }		
		
		$this->_redirect('*/*/');			
	}	 
	
	public function massExportAction()
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
                    $auction = Mage::getModel('magebid/auction')->load($id);			

                    //If the auction is not active
                    if ($auction->getMagebidEbayStatusId()!=$auction->getEbayStatusCreated())
                    {
						//Set error message
						Mage::getSingleton('adminhtml/session')->addError(
		                    Mage::helper('magebid')->__('Auction %s was already exported',$auction->getEbayItemId())
		                );	                    	
                    }                      
					else if ($auction->ebayExport())
					{
		                Mage::getSingleton('adminhtml/session')->addSuccess(
		                    Mage::helper('magebid')->__('Auction %s was exported successfully',$auction->getEbayItemId())
		                );						
					}								
                }
            } 
			catch (Exception $e)
			{
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
		
        $this->indexAction();
	}
	
	
	
	public function massEndItemsAction()
	{		
		$ids = $this->getRequest()->getParam('id');
		$reason = $this->getRequest()->getParam('reason');
		
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
                    $auction = Mage::getModel('magebid/auction')->load($id);	
                    
                    //If the auction is not active
                    if ($auction->getMagebidEbayStatusId()!=$auction->getEbayStatusActive())
                    {
						//Set error message
						Mage::getSingleton('adminhtml/session')->addError(
		                    Mage::helper('magebid')->__('Auction %s is not active',$auction->getEbayItemId())
		                );	                    	
                    }                    
					else if (Mage::getModel('magebid/ebay_items')->endItem($auction->getEbayItemId(),$reason))
					{
					    //Set item status to finished
						$data['magebid_ebay_status_id'] = $auction->getEbayStatusFinished();
						$auction->addData($data)->save();
						
						//Set success message
						Mage::getSingleton('adminhtml/session')->addSuccess(
		                    Mage::helper('magebid')->__('Auction %s was terminated successfully',$auction->getEbayItemId())
		                );													
					}
                }
            } 
			catch (Exception $e)
			{
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
		
        $this->indexAction();
	}	
	
	
	public function previewEbayDescriptionAction()
	{
		if( $this->getRequest()->getParam('id') ) {
            $magebidData = Mage::getModel('magebid/auction')
                ->load($this->getRequest()->getParam('id'));
			exit($magebidData->getAuctionDescription());
        }		
	}	
	
	
    /**
     * Get categories fieldset block
     *
     */
    public function categoriesAction()
    {        
		
		if( $this->getRequest()->getParam('id') ) {
            $magebidData = Mage::getModel('magebid/auction')
                ->load($this->getRequest()->getParam('id'));
            Mage::register('frozen_magebid', $magebidData);
        }     
		
		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tab_category')->toHtml()
        );
    }	
	
    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tab_category')
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