<?php
/**
 * Netresearch_Magebid_Model_Auction
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Auction extends Mage_Core_Model_Abstract
{
    /**
     * Auction Status for created Auctions
     * @const int
     */	
	const AUCTION_STATUS_CREATED = 0;
	
    /**
     * Auction Status for prepared Auctions
     * @const int
     */		
	const AUCTION_STATUS_PREPARED = 1;
	
    /**
     * Auction Status for active Auctions
     * @const int
     */			
	const AUCTION_STATUS_ACTIVE = 2;	
	
    /**
     * Auction Status for finished Auctions
     * @const int
     */		
	const AUCTION_STATUS_FINISHED = 3;
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/auction');
    }	
	
    /**
     * Get Auction Collection
     * 
     * @return object
     */    
	public function getCollection()
	{
		$collection = parent::getCollection();	
		$collection->joinFields();	
		return $collection;
	}	
	
    /**
     * Update the auction details data and check if the status ob the auction has changed
     * 
     * @param array $ebay_item_information ebatns response data
     *
     * @return void
     */	 
	public function ebayUpdate($ebay_item_information)
	{
		//if status is active
		if ($this->getMagebidEbayStatusId()==self::AUCTION_STATUS_CREATED || $this->getMagebidEbayStatusId()==self::AUCTION_STATUS_FINISHED)
			 return false;
		
		//Update auction details
		$magebid_auction_detail = Mage::getModel('magebid/auction_detail')->load($this->getMagebidAuctionDetailId());
		$magebid_auction_detail->addData($ebay_item_information);		
	    $magebid_auction_detail->save();
		$this->load($this->getId()); //reload
		
		//Check Auction-Status
		$this->_checkStatus($magebid_auction_detail,$ebay_item_information);			
	}	
	
    /**
     * Check the response from eBay and change the status if necessary
     * 
     * @param Netresearch_Magebid_Auction_Detail $magebid_auction_detail Magento Auction Detail Object
     * @param array $ebay_item_information ebatns response data
     *
     * @return void
     */	 	
	protected function _checkStatus($magebid_auction_detail,$ebay_item_information)
	{
		//Set special flag to don't change payment and shipping method
		$data['request_type'] = 'update';
		
		//If Auction is finished
		if ($ebay_item_information['ListingStatus']=='Completed')
		{
			//Set Status to finished
			$data['magebid_ebay_status_id'] = self::AUCTION_STATUS_FINISHED;
			$this->addData($data)->save();	
			
			//Log
			Mage::getModel('magebid/log')->logSuccess("auction-finished","item ".$this->getEbayItemId(),"","",var_export($ebay_item_information,true));
		}		
		
		//if Auction is Active
		if ($ebay_item_information['ListingStatus']=='Active' && $this->getMagebidEbayStatusId()!=self::AUCTION_STATUS_ACTIVE)
		{	
			//Set Status to active
			$data['magebid_ebay_status_id'] = self::AUCTION_STATUS_ACTIVE;
			$this->addData($data)->save();
		}			
	}
	
    /**
     * Export Auction to eBay and change the status of the auction in magebid to active
     *
     * @return array|boolean Returns response array of the ebay request or false if the call failed
     */	 		
	public function ebayExport()
	{			
		if ($this->getMagebidEbayStatusId==self::AUCTION_STATUS_CREATED)
		{		
			//Add Item to Ebay and get response
			if ($response = Mage::getModel('magebid/ebay_items')->addEbayItem($this->getData()))
			{
				//Set special flag to don't change payment and shipping method
				$response['request_type'] = 'export';
				
				//Save auction (set ebay_item_id and status)
				$this->addData($response)->save();				
				
				return $response;
			}		
		}			
		return false;
		
	}
	
    /**
     * Return possible reasons for ending an auction
     *
     * @return array 
     */	 		
	public function getEndItemOptions()
	{
		$options = array(
				'Incorrect'=>Mage::helper('magebid')->__('The start price or reserve price is incorrect'),
				'LostOrBroken'=>Mage::helper('magebid')->__('The item was lost or broken'),
				'NotAvailable'=>Mage::helper('magebid')->__('The item is no longer available for sale'),
				'OtherListingError'=>Mage::helper('magebid')->__('The listing contained an error (other than start price or reserve price'),
				'SellToHighBidder'=>Mage::helper('magebid')->__('The listing has qualifying bids'),
				'Sold'=>Mage::helper('magebid')->__('The vehicle was sold. Applies to local classified listings for vehicles only'),
		);
		
		return $options;
	}
	
    /**
     * Return the different ebay status for an auction
     *
     * @return array 
     */	 		
	public function getEbayStatusOptions()
	{
		$data = array();
		
		$resource = $this->getResource();
		$options = $resource->getEbayStatuses();
		foreach ($options as $option)
		{
			$data[$option['magebid_ebay_status_id']] = $option['status_name'];
		}
		return $data;		
	}	
	
	
	
    /**
     * Call eBay getSellerList and updates the auctions
     * 
     * This function get the date of the oldest active auction in Magebid as $from 
     * and the date now as $now
     *
     * @return void 
     */	 	
	public function updateAuctions()
	{
			//Get Start/End Time
			$from = Mage::getModel('magebid/auction')->getResource()->getOldestStartDate();
			$to = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');			
			
			//Make call
			$items = Mage::getModel('magebid/ebay_items')->getSellerList($from,$to);			
			
			//For every modified item
			foreach ($items as $item)
			{
				//$mapped_item = Mage::getModel('magebid/ebay_items')->getHandler()->mappingItem($item);							
				$auction = Mage::getModel('magebid/auction')->load($item['ebay_item_id'],'ebay_item_id');
				$auction->ebayUpdate($item);
			}	
	}	
	
	
	
    /**
     * Call eBay LastSellerTransactions and updates/created new transactions
     * 
     * This function calls LastSellerTransactions and tries to update/create the transactions
     * After this tryCreateMultipleItemOrders will be executed to create Multiple Item Orders
     *
     * @return boolean 
     */	 	
	public function updateTransactions()
	{
		//Get Start/End Time
		$from = Mage::getSingleton('magebid/configuration')->getLastSellerTransactions();
		$to = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');	

		//Make call
		$transactions = Mage::getModel('magebid/ebay_transaction')->getSellerTransactions($from,$to);		
	
		//For every raw transaction
		foreach ($transactions as $raw_transaction)
		{
			//if transaction status is Incomplete
			Mage::getModel('magebid/transaction')->saveOrUpdate($raw_transaction);			
		}
		
		//Set Time for this Update
		Mage::getSingleton('magebid/configuration')->setLastSellerTransactions($to);	
		
		//Get better eBay-Order-Informations and save them to the single transactions
		Mage::getSingleton('magebid/transaction')->updateEbayOrders();		

		//Try to create multiple item_orders
		Mage::getModel('magebid/transaction')->tryCreateMultipleItemOrders();	
		
		return true;
	}
}
?>
