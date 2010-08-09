<?php
class Netresearch_Magebid_Model_Auction extends Mage_Core_Model_Abstract
{
	//Ebay Time
	protected $_ebaytime;

	//Ebay Status Status
	protected $status_created = 0;
	protected $status_prepared = 1;
	protected $status_active = 2;
	protected $status_finished = 3;
	
	const EBAY_STATUS_PREPARED = 1;
	const EBAY_STATUS_ACTIVE = 2;
	
	
	protected function _construct()
    {
        $this->_init('magebid/auction');
    }	
	
	public function getCollection()
	{
		$collection = parent::getCollection();	
		$collection->joinFields();	
		return $collection;
	}	
	
	public function ebayUpdate($mapped_item = array())
	{
		//if status is aktiv
		if ($this->getMagebidEbayStatusId()==$this->getEbayStatusCreated() || $this->getMagebidEbayStatusId()==$this->getEbayStatusFinished()) return;
		
		//Get eBay-Item-Data
		if (empty($mapped_item)) $mapped_item = Mage::getModel('magebid/ebay_items')->getEbayItem($this->getEbayItemId()); 		

		//Update auction details
		$magebid_auction_detail = Mage::getModel('magebid/auction_detail')->load($this->getMagebidAuctionDetailId());
		$magebid_auction_detail->addData($mapped_item);		
	    $magebid_auction_detail->save();
		$this->load($this->getId()); //reload
		
		//Check Auction-Status
		$this->_checkStatus($magebid_auction_detail,$mapped_item);			
		
		//Try to generate new Transactions for this item		
		//$this->_checkForNewTransactions($mapped_item);
	}	
	
	protected function _checkStatus($magebid_auction_detail,$ebay_item_information)
	{
		//Set special flag to don't change payment and shipping method
		$data['request_type'] = 'update';
		
		//If Auction is finished
		if ($ebay_item_information['ListingStatus']=='Completed')
		{
			//Set Status to finished
			$data['magebid_ebay_status_id'] = $this->getEbayStatusFinished();
			$this->addData($data)->save();	
			
			//Log
			Mage::getModel('magebid/log')->logSuccess("auction-finished","item ".$this->getEbayItemId(),"","",var_export($ebay_item_information,true));
			
			return;
		}		
		
		//if Auction is Active
		if ($ebay_item_information['ListingStatus']=='Active' && $this->getMagebidEbayStatusId()!=$this->getEbayStatusActive())
		{	
			//Set Status to active
			$data['magebid_ebay_status_id'] = $this->getEbayStatusActive();
			$this->addData($data)->save();
			return;
		}					
			
	}
	
	public function ebayExport()
	{			
		if ($this->getMagebidEbayStatusId==0)
		{
			$auction_id = $this->getId();
			$data = $this->getData();
			
			//Add Item to Ebay and get response
			if ($response = Mage::getModel('magebid/ebay_items')->addEbayItem($data))
			{
				//Set special flag to don't change payment and shipping method
				$response['request_type'] = 'export';
				
				//Save auction (set ebay_item_id and status)
				$this->addData($response)->save();	
				
				//Update this auction and get detailed informations
				//$this->load($auction_id)->ebayUpdate();	
				
				return $response;
			}
			else
			{
				return false;
			}			
		}	
	}
	
	public function getEbayStatusCreated()
	{
		return $this->status_created;
	}
		
	public function getEbayStatusPrepared()
	{
		return $this->status_prepared;
	}

	public function getEbayStatusActive()
	{
		return $this->status_active;
	}
	
	public function getEbayStatusFinished()
	{
		return $this->status_finished;
	}
	
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
			Mage::getModel('magebid/transaction')->ebayUpdateNew($raw_transaction);			
		}
		
		//Set Time for this Update
		Mage::getSingleton('magebid/configuration')->setLastSellerTransactions($to);	

		//Try to create multiple item_orders
		Mage::getModel('magebid/transaction')->tryCreateMultipleItemOrders();	
		
		return true;
	}
}
?>
