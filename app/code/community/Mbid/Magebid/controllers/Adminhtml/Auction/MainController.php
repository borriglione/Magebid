<?php
/**
 * Mbid_Magebid_Adminhtml_Auction_MainController
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Adminhtml_Auction_MainController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Main/Grid View
     *
     * @return void
     */	 
	public function indexAction()
    {
        $magebid_ebay_status_id = $this->getRequest()->getParam('magebid_ebay_status_id', false);
		Mage::register('magebid_ebay_status_id', $magebid_ebay_status_id);	
		
		$this->loadLayout();				
        $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_auction_main', 'auction'));
        $this->renderLayout();
    }
    
    /**
     * Edit View
     *
     * @return void
     */	 
	public function editAction()
	{
	    $this->loadLayout();
	    $this->_addContent($this->getLayout()->createBlock('magebid/adminhtml_auction_edit'));
		$this->_addLeft($this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tabs'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	    $this->renderLayout();
	}			
	
    /**
     * Delete item
     *
     * @return void
     */	 
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
	
    /**
     * Save Item
     *
     * @return void
     */	 
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
		
    /**
     * Mass Delete Items
     *
     * @return void
     */	 
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
		
    /**
     * Update all active auctions
     *
     * @return void
     */	 
	public function updateallAction()
	{
        try 
		{		
			//Update all auctions
			Mage::getModel('magebid/auction')->updateAuctions();					
			
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
	
    /**
     * Export Auctions to eBay
     *
     * @return void
     */	 
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
                    if ($auction->getMagebidEbayStatusId()!=Mbid_Magebid_Model_Auction::AUCTION_STATUS_CREATED)
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
                
				//Update all auctions
				//This is necessary to get the link-url and some other important 
				//informations which are not in the result of the addItem()-Call
				sleep(5); //Sleep 5 sek and wait for slow eBay to get the last added items!
				Mage::getModel('magebid/auction')->updateAuctions();
            } 
			catch (Exception $e)
			{
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }		
        $this->indexAction();
	}	
	
    /**
     * End eBay Auctions because of different reasons
     *
     * @return void
     */	 
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
                    if ($auction->getMagebidEbayStatusId()!=Mbid_Magebid_Model_Auction::AUCTION_STATUS_ACTIVE)
                    {
						//Set error message
						Mage::getSingleton('adminhtml/session')->addError(
		                    Mage::helper('magebid')->__('Auction %s is not active',$auction->getEbayItemId())
		                );	                    	
                    }                    
					else if (Mage::getModel('magebid/ebay_items')->endItem($auction->getEbayItemId(),$reason))
					{
					    //Set item status to finished
						$data['magebid_ebay_status_id'] = Mbid_Magebid_Model_Auction::AUCTION_STATUS_FINISHED;
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
	
    /**
     * View eBay-Description-Preview
     *
     * @return void
     */	
	public function previewEbayDescriptionAction()
	{
		if( $this->getRequest()->getParam('id') ) {
            $magebidData = Mage::getModel('magebid/auction')
                ->load($this->getRequest()->getParam('id'));
			exit($magebidData->getAuctionDescription());
        }		
	}	
	
	
    /**
     * View Categories Tab
     *
     * @return void
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
    
    /**
     * View Store Categories Tab
     *
     * @return void
     */	
    public function storeCategoriesAction()
    {        
		if( $this->getRequest()->getParam('id') ) {
            $magebidData = Mage::getModel('magebid/auction')
                ->load($this->getRequest()->getParam('id'));
            Mage::register('frozen_magebid', $magebidData);
        }     
		
		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tab_store_category')->toHtml()
        );
    }	
	
    /**
     * Return JSON of the category-tree
     *
     * @return void
     */
    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tab_category')
                ->getEbayChildTreeJson($this->getRequest()->getParam('category'))
        );
    }	
    
    /**
     * View Store Categories Tab
     *
     * @return void
     */	
    public function storeCategoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_auction_edit_tab_store_category')
                ->getEbayChildTreeJson($this->getRequest()->getParam('category'))
        );
    }	  
    
    /**
     * Return JSON of the category-features
     *
     * @return void
     */ 
    public function categoryFeaturesJsonAction()
    {
    	$ebay_category_id = $this->getRequest()->getParam('category_id', false);
    	$conditions = Mage::getModel('magebid/import_category_features')->getAvailableConditions($ebay_category_id);
        $this->getResponse()->setBody(Zend_Json::encode($conditions));	
    }      	
}

?>