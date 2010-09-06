<?php
/**
 * Netresearch_Magebid_Model_Export
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Export extends Mage_Core_Model_Abstract
{	
    /**
     * Processed Profile data, with all predefined settings to create an auction
     * @var array
     */		
	protected $_processed_profile_data;
	
    /**
     * Product
     * @var Mage_Catalog_Model_Product object
     */		
	protected $_product;	
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/export');
    }	
	
    /**
     * Load Product Instance for the current saved auction
     *
     * @return void
     */		    
	public function setProduct($id)
	{
		$this->_product = Mage::getModel('catalog/product');
		if ($this->_processed_profile_data['store']!="")
		{
			$this->_product->setStoreId($this->_processed_profile_data['store']);				
		}
		$this->_product->load($id);
	}
	
    /**
     * Return Magento GMT Datetime
     *
     * @return string
     */		
	public function getDateTime()
	{
		return Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
	}
	
    /**
     * Return the formated Date (Converts DB-Date-Format |Y-m-d H:i:s| into the Magento Date format, f.e. 18.08.2010 17:54:03)
     * 
     * @param string $date Database Datetime Format
     * 
     * @return string
     */			
	public function formatDateTime($date)
	{
		$format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$date = Mage::app()->getLocale()->date($date, $format);
		$time = $date->getTimestamp();
		return Mage::getModel('core/date')->gmtDate(null, $time);
	}	
	
    /**
     * Return the caluclated end-date of an auction
     * 
     * @param string $start_date Start-Date of the auction
     * @param int $listing_duration Lifetime of the auction in days
     * 
     * @return string
     */		
	public function getEndDate($start_date,$listing_duration)
	{
		$time = Mage::getModel('core/date')->timestamp($start_date);
		$time = $time+(60*60*24*$listing_duration);
		return Mage::getModel('core/date')->gmtDate(null, $time);
	}
	
    /**
     * Assign the processed profile auction settings
     *
     * @param array $ebay_settings Magento Request Data
     *
     * @return void
     */			
	public function setEbaySettings($ebay_settings)
	{
		$this->_processed_profile_data = $ebay_settings;		
	}	

    /**
     * Main Function to prepare the auction to store it in the database
     *
     * @return void
     */		
	public function prepareAuction()
	{
		//Prepare Auction Details Data
		$this->_prepareAuctionDetailsData();
		
		//Prepare Product Related Data
		$this->_prepareProductData();

		//Prepare Price Data
		$this->_preparePriceData();
		
		//Prepare Tax Rate
		$this->_prepareTaxRate();
		
		//Save auction Details
		$magebid_auction_details = Mage::getModel('magebid/auction_detail')->setData($this->_processed_profile_data)->save();		
		$this->_processed_profile_data['magebid_auction_detail_id'] = $magebid_auction_details->getId();
		
		//Prepare Auction Data
		$this->_prepareAuctionData();
		
		//Save main auction
		Mage::getModel('magebid/auction')->setData($this->_processed_profile_data)->save();				
	}
	
    /**
     * Prepare the auction details data to store it in the database
     *
     * @return void
     */		
	protected function _prepareAuctionDetailsData()
	{
		//calculate Auction Life Time
		if (empty($this->_processed_profile_data['start_date']))
		{
			unset($this->_processed_profile_data['start_date']);
			unset($this->_processed_profile_data['end_date']);			
		}	
		
		$this->_processed_profile_data['listing_duration'] = $this->_processed_profile_data['listing_duration'];		

	}
	
    /**
     * Prepare the product data
     *
     * @return void
     */			
	protected function _prepareProductData()
	{	
		//Set auction detail infos
		$this->_processed_profile_data['auction_name'] = $this->_product->getName();
		
		//Set auction infos
		$this->_processed_profile_data['product_id'] = $this->_product->getId();
		$this->_processed_profile_data['product_sku'] = $this->_product->getSku();		
		
		//Build Description
		$template_renderer = Mage::getModel('magebid/template_renderer');
		$template_renderer->setProduct($this->_product);
		$this->_processed_profile_data['auction_description'] = $template_renderer->generateDescription(
												$this->_processed_profile_data['header_templates_id'],
												$this->_processed_profile_data['main_templates_id'],
												$this->_processed_profile_data['footer_templates_id']
												);
	}

    /**
     * Prepare the auction data to store it in the database
     *
     * @return void
     */			
	protected function _prepareAuctionData()
	{
		//Set time
		$this->_processed_profile_data['date_created'] = $this->getDateTime();
		
		//Set Magebid Status
		$this->_processed_profile_data['magebid_ebay_status_id'] = Netresearch_Magebid_Model_Auction::AUCTION_STATUS_CREATED;		
	}

    /**
     * Prepare the price data to store it in the database
     *
     * @return void
     */		
	protected function _preparePriceData()
	{
		//Start Price
		$this->_processed_profile_data['start_price'] = $this->_getPrice('start_price');		
		
		//Fixed Price
		$this->_processed_profile_data['fixed_price'] = $this->_getPrice('fixed_price');
	}
	
    /**
     * Prepare the tax data to store it in the database
     *
     * @return void
     */		
	protected function _prepareTaxRate()
	{
		if ($this->_processed_profile_data['vat_percent'])
		{
			//get product tax rate
			$tax_rate = $this->_product->getTaxPercent();
			$this->_processed_profile_data['vat_percent'] = $tax_rate;			
		}
		else
		{
			$this->_processed_profile_data['vat_percent'] = 0;
		}
	}	
	
    /**
     * Calculate the auction price
     *
     * @return void
     */		
	protected function _getPrice($field)
	{
		//Extract text-string-parts
		$first_char = substr($this->_processed_profile_data[$field],0,1);
		$last_char = substr($this->_processed_profile_data[$field],-1);			
		
		if ($first_char=="+" || $first_char=="-") //relative price
		{
			//Get product-price
			//$product_price = $this->_product->getFinalPrice($this->_processed_profile_data['store']);
			$product_price = Mage::helper('tax')->getPrice($this->_product, $this->_product->getFinalPrice(), true);
			
			if ($last_char=="%") //percentage
			{
				$price_val = substr($this->_processed_profile_data[$field],1,-1); //percentage change
				if ($first_char=="-" && $price_val!=0)
				{
					$product_price = $product_price-($product_price/100*$price_val); 
				}
				else if ($first_char=="+" && $price_val!=0)
				{
					$product_price = $product_price+($product_price/100*$price_val);
				}				
			}
			else 
			{
				$price_val = substr($this->_processed_profile_data[$field],1);
				
				if ($first_char=="-")
				{
					$product_price = $product_price-$price_val;
				}
				else if ($first_char=="+")
				{
					$product_price = $product_price+$price_val;
				}
			}
			
			if ($product_price>1) return $product_price; else return "1";
		}
		else if ($this->_processed_profile_data[$field]!="") //take the absolute price
		{			
			return $this->_processed_profile_data[$field];			
		}		
		else //return the normal product price
		{
			return Mage::helper('tax')->getPrice($this->_product, $this->_product->getFinalPrice(), true);
		}
	}
}
?>
