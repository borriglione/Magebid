<?php
//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'GetItemRequestType.php';;
require_once 'AddItemRequestType.php';
require_once 'EndItemRequestType.php';

/**
 * Mbid_Magebid_Model_Ebay_Ebat_Items
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Ebay_Ebat_Items extends Mage_Core_Model_Abstract
{
    /**
     * Session-Proxy to send Calls to eBay
     * @var object EbatNs_ServiceProxy
     */	
	protected $_sessionproxy;
	
    /**
     * Old error_reporting()-level
     * @var int
     */	
	protected $_old_error_level;
	
    /**
     * Auction-Data for the addItem()-Call
     * @var array
     */	
	protected $_auction_data;
	
    /**
     * ItemType from eBatNs
     * @var object
     */	
	protected $_ebay_item;
	
    /**
     * Gallery-Image Data for the addItem()-Call
     * @var array
     */	
	protected $_image_data;
	
    /**
     * Pagination-Number | 100 entries per page
     * @var int
     */	
	protected $_entries_per_page = 100;
	
    /**
     * Construct
     * 
     * Save current error_reporting()-level
     * Set error-reporting to 0
     * Define session-Proxy
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_items');	
		
		//Set lower Error_Reporting
		$this->_old_error_level = error_reporting();
		error_reporting(E_ERROR | E_PARSE);		
		
		//get Sessionproxy
		$this->_sessionproxy = Mage::getModel('magebid/ebay_ebat_session')->getMagebidConnection();	
    }	
    
    /**
     * Destruct
     * 
     * Reset old error_reporting()-level
     *
     * @return void
     */	
	protected function _destruct() 
	{
		//enable old Error_Reporting
		error_reporting($this->_old_error_level);
	}
	
    /**
     * Call to add a new ebay auction
     * 
     * @param array $auction_data 
     * @param array $gallery_images
     *
     * @return array|boolean If Call was successful return array, else return false
     */		
	public function addEbayItem($auction_data,$gallery_images)
	{
        //Build request
		$req = new AddItemRequestType();		
		
		//Set auction data
		$this->_auction_data = $auction_data;
		
		$this->_image_data = $gallery_images;
		
		//set main item Params
		$this->_ebay_item = $this->_setItemParams();
		
		//Depends on Auction Type
		$this->_setAuctionTypeAndPrice();		
		
		//set categories
		$this->_setPrimaryCategorie();
		if ($this->_auction_data['ebay_category_2']!="" && $this->_auction_data['ebay_category_2']!=0) $this->_setSecondaryCategorie();
		
		//set Images
		$this->_setImage();		
		
		//set Layout
		$this->_setLayout();		
		
		//set Return Policy
		$this->_setReturnPolicy();
		
		//set ShippingInfo
		$this->_setShipping();	
		
		//set Payment	
		$this->_setPayment();
		
		//set TAX	
		$this->_setTax();		
		
		//Call 
		$req->setItem($this->_ebay_item);
		$res = $this->_sessionproxy->AddItem($req);

		if ($res->Ack == 'Success')
		{
		   	//Build response
			$response = array();
			$response['ebay_item_id'] = $res->ItemID;
			$response['start_date'] = $res->StartTime;	
			$response['end_date'] = $res->EndTime;		
			
			Mage::getModel('magebid/log')->logSuccess("auction-add","auction ".$response['ebay_item_id'],var_export($req,true),var_export($res,true),var_export($response,true));		
			return $response;
		}
		elseif ($res->Ack == 'Warning')
		{
			//Build response			
			$response = array();
			$response['ebay_item_id'] = $res->ItemID;
			$response['start_date'] = $res->StartTime;	
			$response['end_date'] = $res->EndTime;	
			
			//Set Warning
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionAuctionHandling($res,$res->ItemID);
			Mage::getSingleton('adminhtml/session')->addWarning($message);			
			Mage::getModel('magebid/log')->logWarning("auction-add","auction ".$response['ebay_item_id'],var_export($req,true),var_export($res,true),var_export($response,true));
			return $response;			
		}
		else
		{					
			//Set Error	
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionAuctionHandling($res,$auction_data['magebid_auction_id']);
			Mage::getSingleton('adminhtml/session')->addError($message);	
			Mage::getModel('magebid/log')->logError("auction-add","auction id ".$auction_data['magebid_auction_id'],var_export($req,true),var_export($res,true));			
			return false;
		}	
	}
	
    /**
     * Set general item informations 
     * 
     * @return object ItemType
     */		
	protected function _setItemParams()
	{
        $item = new ItemType();
        $item->setTitle($this->_auction_data['auction_name']);       
        $item->setCurrency($this->_auction_data['currency']);
        $item->setCountry($this->_auction_data['country']);		
		if (!empty($this->_auction_data['start_date']) && ($this->_auction_data['start_date'] != '0000-00-00 00:00:00')) $item->setScheduleTime($this->_auction_data['start_date']);	
        $item->setListingDuration($this->_auction_data['listing_duration']);
        $item->setLocation($this->_auction_data['location']);        
        $item->setDispatchTimeMax($this->_auction_data['dispatch_time']); 
        $item->setDescription($this->_auction_data['auction_description']);		
	    $item->setConditionID($this->_auction_data['condition_id']);
        return $item;	
	}
	
    /**
     * Set primary category
     * 
     * @return void
     */		
	protected function _setPrimaryCategorie()
	{
        $primaryCategory = new CategoryType();
        $primaryCategory->setCategoryID($this->_auction_data['ebay_category_1']);
        $this->_ebay_item->setPrimaryCategory($primaryCategory);		
	}
	
    /**
     * Set secondary category
     * 
     * @return void
     */	
	protected function _setSecondaryCategorie()
	{
		$secondaryCategory = new CategoryType();
		$secondaryCategory->setCategoryID($this->_auction_data['ebay_category_2']);
		$this->_ebay_item->setSecondaryCategory($secondaryCategory);		
	}	

    /**
     * Set Return Policy
     * 
     * @return void
     */	
	protected function _setReturnPolicy()
	{
		$retpol = new ReturnPolicyType();
		if (isset($this->_auction_data['refund_option'])) $retpol->setRefundOption($this->_auction_data['refund_option']);
		if (isset($this->_auction_data['returns_within_option'])) $retpol->setReturnsWithinOption("Days_".$this->_auction_data['returns_within_option']);
		if (isset($this->_auction_data['returns_accepted_option'])) $retpol->setReturnsAcceptedOption($this->_auction_data['returns_accepted_option']);
		if (isset($this->_auction_data['returns_description'])) $retpol->setDescription($this->_auction_data['returns_description']);
		$this->_ebay_item->setReturnPolicy($retpol);		
	}	
	
    /**
     * Set Shipping Information
     * 
     * @return void
     */	
	protected function _setShipping()
	{
		$ship = new ShippingDetailsType();
		$i=0;
		
		foreach ($this->_auction_data['shipping_methods'] as $shipping_method)
		{
			$ship_options = new ShippingServiceOptionsType();
			$ship_options->setShippingService($shipping_method['shipping_method']);
			$ship_options->setShippingServiceCost($shipping_method['price']);
			if (isset($shipping_method['add_price'])) 
			{
				$ship_options->setShippingServiceAdditionalCost($shipping_method['add_price']);
			}
			else
			{
				$ship_options->setShippingServiceAdditionalCost(0);
			}
			 						
			$ship_options->setShippingServicePriority($i++);	//Fix in v.2
			$ship->addShippingServiceOptions($ship_options);
		}		
		
				
		$this->_ebay_item->setShippingDetails($ship);
	}
	
    /**
     * Set Payment Information
     * 
     * @return void
     */	
	protected function _setPayment()
	{
		$payment_methods = array();
		
		foreach ($this->_auction_data['payment_methods'] as $payment_method)
		{
			$payment_methods[] = $payment_method['payment_method'];
			if ($payment_method['payment_method']=='PayPal') $this->_ebay_item->setPayPalEmailAddress(Mage::getSingleton('magebid/setting')->getPaypalMail());
		}

		$this->_ebay_item->setPaymentMethods($payment_methods); 
	}	
	
    /**
     * Set Image Information
     * 
     * @return void
     */	
	protected function _setImage()
	{       
	    $picture = new PictureDetailsType();
        
		if ($this->_auction_data['is_image']==1)
		{
			$picture = new PictureDetailsType();
			$picture->setPictureURL($this->_image_data['main']);
			if ($this->_auction_data['is_galery_image']==1) $picture->setGalleryType('Gallery');  
			$this->_ebay_item->setPictureDetails($picture);	
		}        	
	}
	
    /**
     * Set Auction Type and Price
     * 
     * @return void
     */	
	protected function _setAuctionTypeAndPrice()
	{
		//Regular | Chinese
		if ($this->_auction_data['magebid_auction_type_id']==1)
		{		 
       		$this->_ebay_item->setListingType('Chinese');
			$this->_ebay_item->setQuantity('1');
			$this->_ebay_item->setStartPrice($this->_auction_data['start_price']);
			if ($this->_auction_data['fixed_price']) $this->_ebay_item->setBuyItNowPrice($this->_auction_data['fixed_price']);
		}
		
		//StoreFixPriceItem
		if ($this->_auction_data['magebid_auction_type_id']==2)
		{		 
			$this->_ebay_item->setListingType('FixedPriceItem'); 
			$this->_ebay_item->setQuantity($this->_auction_data['quantity']);
			$this->_ebay_item->setStartPrice($this->_auction_data['fixed_price']);
		}
	}
	
    /**
     * Set layout informations
     * 
     * @return void
     */	
	protected function _setLayout()
	{
		//Set Hitcounter
		$this->_ebay_item->setHitCounter($this->_auction_data['hit_counter']);
		
		//Set Listing Enhancement
		if (isset($this->_auction_data['listing_enhancement']))
		{
			foreach ($this->_auction_data['listing_enhancement'] as $key => $listing_enhancement)
			{
				$this->_ebay_item->addListingEnhancement($listing_enhancement);
			}			
		}
	}
	
    /**
     * Set tax informations
     * 
     * @return void
     */	
	protected function _setTax()
	{
		//Use Tax Table
		if ($this->_auction_data['use_tax_table']==1) $this->_ebay_item->setUseTaxTable('true');
		
		//Set Tax
		if (!is_null($this->_auction_data['vat_percent']) && $this->_auction_data['vat_percent']!=0)
		{
			$vat = new VATDetailsType();
			$vat->setVATPercent($this->_auction_data['vat_percent']);
			$this->_ebay_item->setVATDetails($vat);			
		} 
	}
	
    /**
     * Call to end an active ebay auction
     * 
     * @param int $itemid 
     * @param string $reason
     *
     * @return boolean
     */		
	public function endItem($itemid,$reason)
	{
        //Build request
		$req = new EndItemRequestType();
		
		//Set Params
		$req->setItemID($itemid);
		$req->setEndingReason($reason);
		
		//Call 
		$res = $this->_sessionproxy->EndItem($req);

		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("auction-end","auction ".$itemid,var_export($req,true),var_export($res,true));
			return true;
		}		
		else
		{
			//Set Error
			Mage::getModel('magebid/log')->logError("auction-end","auction ".$itemid,var_export($req,true),var_export($res,true));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionAuctionHandling($res,$itemid);
			Mage::getSingleton('adminhtml/session')->addError($message);
			return false;	
		}		
	}
	
    /**
     * Call to get current auctions in a defined date-rage
     * 
     * @param string $from From-Date 
     * @param string $to To-Date
     * @param int $current_page Current Page
     *
     * @return boolean
     */		
	public function getSellerList($from,$to,$current_page = 1)
	{
        //Build request
		$req = new GetSellerListRequestType();	

		//Set Params
		$req->setStartTimeFrom($from);
		$req->setStartTimeTo($to);
		//$req->setEndTimeFrom($from);
		//$req->setEndTimeTo($to);		
		$req->setDetailLevel('ReturnAll');
		$req->setGranularityLevel('Coarse');		
		
		//Pagination
		$req->Pagination = $this->_pageination($current_page);		
		
		//Call 
		$res = $this->_sessionproxy->GetSellerList($req);

		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("seller-list-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			return $res;
		}		
		else
		{		
			//Set Error
			Mage::getModel('magebid/log')->logError("seller-list-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}		
	}	
	
    /**
     * Mapping Function for the GetSellerList()-Response
     * 
     * @param object $item 
     *
     * @return array
     */	
	public function mappingItem($item)
	{
			$response_array = array();
			$response_array['price_now'] = $item->SellingStatus->CurrentPrice->value;
			$response_array['start_date'] = $item->ListingDetails->StartTime;
			$response_array['end_date'] = $item->ListingDetails->EndTime;
			if ($item->ListingDetails->ViewItemURL!="") $response_array['link'] = $item->ListingDetails->ViewItemURL;		
			$response_array['last_updated'] = date('Y-m-d H:i:s');
			$response_array['ListingStatus'] = $item->SellingStatus->ListingStatus;
			$response_array['quantity_sold'] = $item->SellingStatus->QuantitySold;	
			$response_array['quantity_sold'] = $item->SellingStatus->QuantitySold;	
			$response_array['ebay_item_id'] = $item->ItemID;
			$response_array['full_response'] = $item;	

			return $response_array;
	}
	
    /**
     * Define Pagination-Settings
     * 
     * @param int $current_page 
     *
     * @return object PaginationType
     */	
	protected function _pageination($current_page = 1)
	{		
		//Set Pageination
		$pagination = new PaginationType();
		$pagination->setEntriesPerPage($this->_entries_per_page);
		$pagination->setPageNumber($current_page);
		return $pagination;
	}
}
?>
