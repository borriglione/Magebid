<?php
/**
 * Netresearch_Magebid_Model_Ebay_Items
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Ebay_Items extends Mage_Core_Model_Abstract
{
    /**
     * Handler for Calls to eBay
     * @var object Netresearch_Magebid_Model_Ebay_Ebat_Items
     */	
	protected $_handler;
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/ebay_items');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_items');
	}
	
	/*
	public function getEbayItem($itemid)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		return $this->_handler->getEbayItem($itemid);
	}*/
	
    /**
     * Call to add a new eBay auction
     * 
     * @param array $auction_data Auction information
     *
     * @return array|boolean If call was successful return response array, else return false
     */	 
	public function addEbayItem($auction_data)
	{
		$gallery_images = array();
		
		//Get Product for this auction
		$product = Mage::getModel('catalog/product')->load($auction_data['product_id']);		
		
		//setting main image		
		if ($auction_data['is_image']==1)
		{
			//$gallery_images['main'] = Mage::helper('catalog/image')->init($product, 'image')->__toString();
			$gallery_images['main'] = Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl().$product->getImage();
		}			
		
		if ($response = $this->_handler->addEbayItem($auction_data,$gallery_images))
		{
			$response['magebid_ebay_status_id'] = Netresearch_Magebid_Model_Auction::AUCTION_STATUS_ACTIVE;
			return $response;
		}
		else
		{
			return false;
		}
	}
	
    /**
     * Ending an active ebay aucton
     * 
     * @param int $itemid ebay-item-id
     * @param string $reason predefined eBay Reason string
     *
     * @return boolean
     */	 
	public function endItem($itemid,$reason)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();	
		
		if ($this->_handler->endItem($itemid,$reason))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
    /**
     * Get all auctions of seller in a defined date-range
     * 
     * @param string $from Start Date
     * @param string $to End Date
     *
     * @return array
     */	 	
	public function getSellerList($from,$to)
	{
		$items = array();
		$page = 1;

		do
		{			
			$raw_items = $this->_handler->getSellerList($from,$to,$page);
			foreach ($raw_items->ItemArray as $raw_item)
			{
				$items[] = $this->_handler->mappingItem($raw_item);
			}			
			$page++;

			//Daily Log
			Mage::getModel('magebid/daily_log')->logCall();			
		} 
		while ($page<=$raw_items->PaginationResult->TotalNumberOfPages);	

		return $items;
	}
}

?>
