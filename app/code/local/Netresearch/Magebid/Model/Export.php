<?php
class Netresearch_Magebid_Model_Export extends Mage_Core_Model_Abstract
{
	protected $_product_id;
	protected $_ebay_settings;
	protected $_product;
	protected $_auction;
	
	protected function _construct()
    {
        $this->_init('magebid/export');
    }	
	
	public function setProduct($id)
	{
		$this->_product_id = $id;
		$this->_product = Mage::getModel('catalog/product');
		if ($this->_ebay_settings['store']!="" && $this->_ebay_settings!=0) $this->_product->setStoreId($this->_ebay_settings['store']);				
		$this->_product->load($id);
	}
	
	public function getDateTime()
	{
		return Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
	}
	
	public function formatDateTime($date)
	{
		$format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$date = Mage::app()->getLocale()->date($date, $format);
		$time = $date->getTimestamp();
		return Mage::getModel('core/date')->gmtDate(null, $time);
	}	
	
	public function getEndDate($start_date,$life_time)
	{
		$time = Mage::getModel('core/date')->timestamp($start_date);
		$time = $time+(60*60*24*$life_time);
		return Mage::getModel('core/date')->gmtDate(null, $time);
	}
	
	public function setEbaySettings($ebay_settings)
	{
		$this->_ebay_settings = $ebay_settings;		
	}	
	
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
		$magebid_auction_details = Mage::getModel('magebid/auction_detail')->setData($this->_ebay_settings)->save();		
		$this->_ebay_settings['magebid_auction_detail_id'] = $magebid_auction_details->getId();
		
		//Prepare Auction Data
		$this->_prepareAuctionData();
		
		//Save main auction
		$this->_auction = Mage::getModel('magebid/auction')->setData($this->_ebay_settings)->save();				
	}
	
	
	protected function _prepareAuctionDetailsData()
	{
		//calculate Auction Life Time
		if (empty($this->_ebay_settings['start_date']))
		{
			unset($this->_ebay_settings['start_date']);
			unset($this->_ebay_settings['end_date']);			
		}	
		
		$this->_ebay_settings['life_time'] = $this->_ebay_settings['duration'];		

	}
	
	protected function _prepareProductData()
	{	
		//Set auction detail infos
		$this->_ebay_settings['auction_name'] = $this->_product->getName();
		
		//Set auction infos
		$this->_ebay_settings['product_id'] = $this->_product->getId();
		$this->_ebay_settings['product_sku'] = $this->_product->getSku();		
		
		//Build Description
		$template_renderer = Mage::getModel('magebid/template_renderer');
		$template_renderer->setProduct($this->_product);
		$this->_ebay_settings['auction_description'] = $template_renderer->generateDescription(
												$this->_ebay_settings['header_templates_id'],
												$this->_ebay_settings['main_templates_id'],
												$this->_ebay_settings['footer_templates_id']
												);
	}
	
	protected function _prepareAuctionData()
	{
		//Set time
		$this->_ebay_settings['date_created'] = $this->getDateTime();
		
		//Set Magebid Status
		$this->_ebay_settings['magebid_ebay_status_id'] = Mage::getSingleton('magebid/auction')->getEbayStatusCreated();		
	}
	
	protected function _preparePriceData()
	{
		//Start Price
		$this->_ebay_settings['start_price'] = $this->_getPrice('start_price');		
		
		//Fixed Price
		$this->_ebay_settings['fixed_price'] = $this->_getPrice('fixed_price');
	}
	
	protected function _prepareTaxRate()
	{
		if ($this->_ebay_settings['vat_percent'])
		{
			//get product tax rate
			$tax_rate = $this->_product->getTaxPercent();
			$this->_ebay_settings['vat_percent'] = $tax_rate;			
		}
		else
		{
			$this->_ebay_settings['vat_percent'] = 0;
		}
	}	
	
	protected function _getPrice($field)
	{
		//Extract text-string-parts
		$first_char = substr($this->_ebay_settings[$field],0,1);
		$last_char = substr($this->_ebay_settings[$field],-1);			
		
		if ($first_char=="+" || $first_char=="-") //relative price
		{
			//Get product-price
			//$product_price = $this->_product->getFinalPrice($this->_ebay_settings['store']);
			$product_price = Mage::helper('tax')->getPrice($this->_product, $this->_product->getFinalPrice(), true);
			
			if ($last_char=="%") //percentage
			{
				$price_val = substr($this->_ebay_settings[$field],1,-1); //percentage change
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
				$price_val = substr($this->_ebay_settings[$field],1);
				
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
		else //absolute price
		{			
			return $this->_ebay_settings[$field];			
		}		
	}
}
?>
