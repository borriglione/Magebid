<?php

class Netresearch_Magebid_Model_Ebay_Items extends Mage_Core_Model_Abstract
{
	protected $_handler;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_items');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_items');
	}
	
	public function getEbayItem($itemid)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		return $this->_handler->getEbayItem($itemid);
	}
	
	public function getHandler()
	{
		return $this->_handler;
	}
	
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
			$response['magebid_ebay_status_id'] = Mage::getSingleton('magebid/auction')->getEbayStatusActive();
			return $response;
		}
		else
		{
			return false;
		}
	}
	
    protected function _getGalleryUrl($product,$image=null)
    {
        $params = array('id'=>$product->getId());
        if ($image) {
            $params['image'] = $image->getValueId();
            return $this->getUrl('*/*/gallery', $params);
        }
        return $this->getUrl('*/*/gallery', $params);
    }	
	
	public function endItem($itemid,$reason)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();	
		
		if ($this->_handler->endItem($itemid,$reason))
		{
			return true;
		}
	}
	
	public function getLastSellerEvents($from,$to)
	{
		return $this->_handler->getLastSellerEvents($from,$to);
	}	
	
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
