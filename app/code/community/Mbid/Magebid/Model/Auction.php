<?php
/**
 * Mbid_Magebid_Model_Auction
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Auction extends Mage_Core_Model_Abstract
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
	 * Auction Status for active Auctions
	 * @const int
	 */
	const AUCTION_STATUS_AUTOMATICINSERT = -1;

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

	public function importFullAuction($ebay_item_information) {
		$Export = Mage::getModel('magebid/export');

		$data = array();
		//later:
		//$data['product_id'] = $this->_product->getId();
		//$data['product_sku'] = $this->_product->getSku();
		$data['product_id'] = 1;
		$data['product_sku'] = '001';

		//set initial status
		$data['magebid_ebay_status_id'] = Mbid_Magebid_Model_Auction::AUCTION_STATUS_AUTOMATICINSERT;

		//set creation date to now
		$data['date_created'] = $Export->getDateTime();

		//let undefined, we dont know yet
		$data['magebid_auction_type_id'] = 0;

		//@TODO	TODO	speed-performance: dont query every time the options from db, save them for this instance in this object or something!
		$data['magebid_auction_type_id'] = Mage::getModel('magebid/auction_type')->getAuctionTypeId($ebay_item_information['auction_type']);
		if(!$data['magebid_auction_type_id']) {
			Mage::getModel('magebid/log')->logError("auction-import-full","ebay item id ".$data['ebay_item_id'],'could not find auction type id in db',var_export($ebay_item_information,true));
			return false;
		}

		$magebid_auction_details = Mage::getModel('magebid/auction_detail')->setData($ebay_item_information)->save();
		$data['magebid_auction_detail_id'] = $magebid_auction_details->getId();

		$data['ebay_item_id'] = $ebay_item_information['ebay_item_id'];

		//is later set by update ebayUpdate() -> _checkStats()
		//$data['magebid_ebay_status_id'] = $status;

		$this->setData($data)->save();

		return true;

//just copied from existing source:
/*
//$ebay_settings is post array form prepare product to auction listing
$this->_processed_profile_data = $ebay_settings;
//Save auction Details
		$this->_processed_profile_data['product_id'] = $this->_product->getId();
		$this->_processed_profile_data['product_sku'] = $this->_product->getSku();

		$this->_processed_profile_data['magebid_ebay_status_id'] = Mbid_Magebid_Model_Auction::AUCTION_STATUS_CREATED;

		$this->_processed_profile_data['date_created'] = $this->getDateTime();

		//in table magebid_auction_type
		$this->_processed_profile_data['magebid_auction_type_id'] = 2;

		$magebid_auction_details = Mage::getModel('magebid/auction_detail')->setData($this->_processed_profile_data)->save();
		$this->_processed_profile_data['magebid_auction_detail_id'] = $magebid_auction_details->getId();
		Mage::getModel('magebid/auction')->setData($this->_processed_profile_data)->save();

		//second part (export auctoin to ebay)

		$response = $ebay_item_information;
		//$response = $this->_handler->addEbayItem($auction_data,$gallery_images);
		$response['magebid_ebay_status_id'] = Mbid_Magebid_Model_Auction::AUCTION_STATUS_ACTIVE;
		//Save auction (set ebay_item_id and magebid_ebay_status_id)
		$this->addData($response)->save();


		Mage::log(var_export($ebay_item_information,true),null,'magebid_importFullAuction.log');
*/

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
		if(!$this->getId() && !$this->importFullAuction($ebay_item_information))
		{
			return;
		}

		//if status is not active (auction prepared for export/finishd)
		if ($this->getMagebidEbayStatusId()==self::AUCTION_STATUS_CREATED || $this->getMagebidEbayStatusId()==self::AUCTION_STATUS_FINISHED)
		{
			return false;
		}

		//Update auction details
		$magebid_auction_detail = Mage::getModel('magebid/auction_detail')->load($this->getMagebidAuctionDetailId());
		$magebid_auction_detail->addData($ebay_item_information);
	    $magebid_auction_detail->save();

	    Mage::getModel('magebid/log')->logSuccess("ebay-update","auction-id ".$this->getId(),"","",var_export($ebay_item_information,true));

		//@TODO	TODO	why reload?
		$this->load($this->getId()); //reload

		//Check Auction-Status
		$this->_checkStatus($magebid_auction_detail,$ebay_item_information);
	}

    /**
     * Check the response from eBay and change the status if necessary
     *
     * @param Mbid_Magebid_Auction_Detail $magebid_auction_detail Magento Auction Detail Object
     * @param array $ebay_item_information ebatns response data
     *
     * @return void
     */
	protected function _checkStatus($magebid_auction_detail,$ebay_item_information)
	{
		//Set special flag to don't change payment and shipping method
		//@TODO TODO is this for a future purpose?
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
				//@TODO	TODO	is this used right now?
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
		$data = array(
			self::AUCTION_STATUS_CREATED => Mage::helper('magebid')->__('Not added'),
			self::AUCTION_STATUS_PREPARED=> Mage::helper('magebid')->__('Prepared in eBay'),
			self::AUCTION_STATUS_ACTIVE=> Mage::helper('magebid')->__('Active'),
			self::AUCTION_STATUS_FINISHED=> Mage::helper('magebid')->__('Finished'),
		);

		return $data;
	}

	public function updateAuctionsBySellerEvents() {
		echo 'check get seller events';
		//just to check/understand ebay:
		//response includes new items and modified items (also gtc items with new end date or desription change or sku change??)
    	$time = Mage::getModel('core/date')->timestamp() - (60*60*24)*2;
		$from = Mage::getModel('core/date')->gmtDate(null, $time);
		$to = Mage::getModel('core/date')->gmtDate();
		$items = Mage::getModel('magebid/ebay_items')->getSellerEvents($from,$to);
var_dump($from,$to,$items);
		foreach($items as $item) {
			if($item['ebay_item_id'] == '380149040540') {
				var_dump($item);
				die();
			}
		}
die();
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
		$this->updateAuctionsBySellerEvents();

		//Get Start/End Time for startDate or ,when eanbled, endDate
		$from1 = Mage::getModel('magebid/auction')->getResource()->getOldestStartDate();
		$to1 = Mage::getModel('magebid/auction')->getResource()->getFutureStartDate();

		//check time difference is more than 120 days and if, reset $to to a 120 days time period
		list($from2,$to2) = Mage::getModel('magebid/auction')->getResource()->checkTimeDifference($from1,$to1,120);

		if($to1 != $to2)
		{
			Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('magebid')->__('The last update was too long ago. To be up to date, you have to refresh a second time.')
            );
		}
		$to = $to2;

		if($from1 != $from2)
		{
			Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('magebid')->__('The last update was too long ago. There will be missing some orders.')
            );
		}
		$from = $from2;

		//Make call
		if ($from!="") //If there is a start date
		{
			$items = Mage::getModel('magebid/ebay_items')->getSellerList($from,$to);

			Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('magebid')->__('%s items found',count($items))
            );

			//For every modified item
			foreach ($items as $item)
			{
				$auction = Mage::getModel('magebid/auction')->load($item['ebay_item_id'],'ebay_item_id');
				$auction->ebayUpdate($item);
			}
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
		$to = Mage::getModel('core/date')->gmtDate();

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
