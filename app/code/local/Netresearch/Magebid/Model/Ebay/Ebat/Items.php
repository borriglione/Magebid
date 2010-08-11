<?php
//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'GetItemRequestType.php';;
require_once 'AddItemRequestType.php';
require_once 'EndItemRequestType.php';

class Netresearch_Magebid_Model_Ebay_Ebat_Items extends Mage_Core_Model_Abstract
{
	protected $_sessionproxy;
	protected $_old_error_level;
	protected $_auction_data;
	protected $_ebay_item;
	protected $_image_data;
	
	//Pagination
	protected $_entries_per_page = 100;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_items');	
		
		//Reset error_level
		//disable Error_Reporting
		$this->_old_error_level = error_reporting();
		error_reporting(0);		
		
		//get Sessionproxy
		$this->_sessionproxy = Mage::getModel('magebid/ebay_ebat_session')->getMagebidConnection();	
    }	
	
	protected function _destruct() 
	{
		//enable old Error_Reporting
		error_reporting($this->_old_error_level);
	}
	
	
	public function getEbayItem($itemid)
	{
		$req = new GetItemRequestType(); 
		$req->setItemID($itemid);      				
		$res = $this->_sessionproxy->GetItem($req);	
		
		if ($res->Ack == 'Success')
		{
			//Set response array
			$mapped_item = $this->mappingItem($res->Item);
									
			//Log
			Mage::getModel('magebid/log')->logSuccess("auction-update","auction ".$itemid,var_export($req,true),var_export($res,true));
							
			return $mapped_item;				
		}
		else
		{
			//Log
			Mage::getModel('magebid/log')->logError("auction-update","auction ".$itemid,var_export($req,true),var_export($res,true));
			return false;
		}		
	}	
	
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
		
		//print_r($this->_ebay_item);
		//exit();
		
		//Call 
		$req->setItem($this->_ebay_item);
		$res = $this->_sessionproxy->AddItem($req);

		//print_r($res);
		//exit();		
		
		if ($res->Ack == 'Success')
		{
		   	//Build response
			$response = array();
			$response['ebay_item_id'] = $res->ItemID;	
			Mage::getModel('magebid/log')->logSuccess("auction-add","auction ".$response['ebay_item_id'],var_export($req,true),var_export($res,true));		
			return $response;
		}
		elseif ($res->Ack == 'Warning')
		{
			//Build response			
			$response = array();
			$response['ebay_item_id'] = $res->ItemID;
			
			//Set Error
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res,$res->ItemID);
			Mage::getSingleton('adminhtml/session')->addWarning($message);			
			Mage::getModel('magebid/log')->logWarning("auction-add","auction ".$response['ebay_item_id'],var_export($req,true),var_export($res,true));
			return $response;			
		}
		else
		{
			//Set Error
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res,$res->ItemID);
			Mage::getSingleton('adminhtml/session')->addError($message);	
			Mage::getModel('magebid/log')->logError("auction-add","auction id ".$auction_data['magebid_auction_id'],var_export($req,true),var_export($res,true));			
			return false;
		}		
	}
	
	
	
	protected function _setItemParams()
	{
        $item = new ItemType();
        $item->setTitle($this->_auction_data['auction_name']);       
        $item->setCurrency($this->_auction_data['currency']);
        $item->setCountry($this->_auction_data['country']);		
		if (!empty($this->_auction_data['start_date']) && ($this->_auction_data['start_date'] != '0000-00-00 00:00:00')) $item->setScheduleTime($this->_auction_data['start_date']);	
        $item->setListingDuration('Days_'.$this->_auction_data['life_time']);
        $item->setLocation($this->_auction_data['location']);        
        $item->setDispatchTimeMax($this->_auction_data['dispatch_time']); 
        $item->setDescription(Mage::helper('coding')->exportEncodeHtml($this->_auction_data['auction_description']));		
		$item->setConditionID($this->_auction_data['condition_id']);
        return $item;	
	}
	
	protected function _setPrimaryCategorie()
	{
        $primaryCategory = new CategoryType();
        $primaryCategory->setCategoryID($this->_auction_data['ebay_category_1']);
        $this->_ebay_item->setPrimaryCategory($primaryCategory);		
	}
	
	protected function _setSecondaryCategorie()
	{
		$secondaryCategory = new CategoryType();
		$secondaryCategory->setCategoryID($this->_auction_data['ebay_category_2']);
		$this->_ebay_item->setSecondaryCategory($secondaryCategory);		
	}	


	protected function _setReturnPolicy()
	{
		$retpol = new ReturnPolicyType();
		if (isset($this->_auction_data['refund_option'])) $retpol->setRefundOption($this->_auction_data['refund_option']);
		if (isset($this->_auction_data['returns_within_option'])) $retpol->setReturnsWithinOption("Days_".$this->_auction_data['returns_within_option']);
		if (isset($this->_auction_data['returns_accepted_option'])) $retpol->setReturnsAcceptedOption($this->_auction_data['returns_accepted_option']);
		if (isset($this->_auction_data['returns_description'])) $retpol->setDescription(Mage::helper('coding')->exportEncodeHtml($this->_auction_data['returns_description']));
		$this->_ebay_item->setReturnPolicy($retpol);		
	}	
	
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
	
	protected function _setAuctionTypeAndPrice()
	{
		//Regular | Chinese
		if ($this->_auction_data['magebid_auction_type_id']==1)
		{		 
       		$this->_ebay_item->setListingType('Chinese');
			$this->_ebay_item->setQuantity('1');
			$this->_ebay_item->setStartPrice($this->_auction_data['start_price']);
			if ($this->_auction_data['fixed_price']) $this->_ebay_item->setBuyItNowPrice($this->_auction_data['fixed_price']);
			return;			
		}
		
		//StoreFixPriceItem
		if ($this->_auction_data['magebid_auction_type_id']==2)
		{		 
			$this->_ebay_item->setListingType('FixedPriceItem'); 
			$this->_ebay_item->setQuantity($this->_auction_data['quantity']);
			$this->_ebay_item->setStartPrice($this->_auction_data['fixed_price']);
			return;			
		}
	}
	
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
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res,$itemid);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}		
	}
	
	public function getLastSellerEvents($from,$to)
	{
        //Build request
		$req = new GetSellerEventsRequestType();	

		//Set Params
		$req->setModTimeFrom($from);
		$req->setModTimeTo($to);
		$req->setDetailLevel('ReturnAll');
		
		//Call 
		$res = $this->_sessionproxy->GetSellerEvents($req);

		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("seller-events-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			return $res;
		}		
		else
		{
			//Set Error
			Mage::getModel('magebid/log')->logError("seller-events-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res,$itemid);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}			
	}
	
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
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res,$itemid);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}			
	}	
	
	public function mappingItem($item)
	{
			$response_array['price_now'] = $item->SellingStatus->CurrentPrice->value;
			$response_array['start_date'] = $item->ListingDetails->StartTime;
			$response_array['end_date'] = $item->ListingDetails->EndTime;
			if ($item->ListingDetails->ViewItemURL!="") $response_array['link'] = $item->ListingDetails->ViewItemURL;		
			$response_array['last_updated'] = date('Y-m-d H:i:s');
			$response_array['ListingStatus'] = $item->SellingStatus->ListingStatus;
			$response_array['quantity_sold'] = $item->SellingStatus->QuantitySold;	
			$response_array['quantity_sold'] = $item->SellingStatus->QuantitySold;	
			$response_array['ebay_item_id'] = $item->ItemID;
			//$response_array['full_response'] = $item;	

			return $response_array;
	}
	
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
