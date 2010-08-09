<?php
class Netresearch_Magebid_Model_Import_Shipping extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/import_shipping');
    }	
	
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
			//echo Mage::helper('coding')->importEncodeString($shipping_service->ShippingService),"<br />";
			
			//Build the data
			$data = array(
				'shipping_service' => Mage::helper('coding')->importEncodeString($shipping_service->ShippingService),
				'shipping_service_id' => $shipping_service->ShippingServiceID,
				'description' => Mage::helper('coding')->importEncodeString($shipping_service->Description),				
				);
				
			if ($shipping_service->ShippingCarrier[0]!="") $data['carrier'] = Mage::helper('coding')->importEncodeString($shipping_service->ShippingCarrier[0]);
			if ($shipping_service->InternationalService==1) $data['international'] = 1; else $data['international'] = 0;				
			
			//save
			$this->setData($data)->save();
		}	
		
		return count($ebay_shipping_methods->ShippingServiceDetails);
	}
	
}
?>
