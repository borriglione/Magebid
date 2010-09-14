<?php
/**
 * Mbid_Magebid_Model_Import_Shipping
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Import_Shipping extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/import_shipping');
    }	
	
    /**
     * Import the avaiable Shipping Methods from eBay
     *
     * @return void
     */	    
	public function importEbayShippingMethods()
	{
		//get all Shipping Methods
		$ebay_shipping_methods = Mage::getModel('magebid/ebay_miscellaneous')->geteBayDetails('ShippingServiceDetails');
		
		//If there are some shipping services
		if (count($ebay_shipping_methods->ShippingServiceDetails)>0)
		{
			//delete all existing shipping services
			$collection = $this->getCollection();
			foreach ($collection as $colItem){
			       $colItem->delete();
			} 		
		}
		
		//Add the new Shipping Services
		foreach ($ebay_shipping_methods->ShippingServiceDetails as $shipping_service)
		{
			//Build the data
			$data = array(
				'shipping_service' => $shipping_service->ShippingService,
				'shipping_service_id' => $shipping_service->ShippingServiceID,
				'description' => $shipping_service->Description,				
				);
				
			if ($shipping_service->ShippingCarrier[0]!="") $data['carrier'] = $shipping_service->ShippingCarrier[0];
			if ($shipping_service->InternationalService==1) $data['international'] = 1; else $data['international'] = 0;				
			
			//save
			$this->setData($data)->save();
		}			
		return count($ebay_shipping_methods->ShippingServiceDetails);
	}	
}
?>
