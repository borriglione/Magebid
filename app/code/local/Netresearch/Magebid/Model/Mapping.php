<?php
class Netresearch_Magebid_Model_Mapping extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/mapping');
    }	
	
	public function saveMapping($data)
	{
		//Save Shipping Mapping
		$this->saveShippingMapping($data);		
		
		//Save Payment Mapping
		$this->savePaymentMapping($data);
	}
	
	protected function saveShippingMapping($data)
	{
		
		//Get Resource Model
		$resource_model = $this->getResource();
		
		//Delete old Shipping Mappings
		$collection = $this->getCollection();
		$collection->addFilter('kind','shipping');
		foreach ($collection as $colItem)
		{
			       $colItem->delete();
		} 		
		
		//Save
		if (isset($data['shipping_method']))
		{
			foreach ($data['shipping_method'] as $shipping_mapping)
			{
				if ($shipping_mapping['delete']=='1') continue;
				
				//Build the data
				$data = array(
					'kind' => 'shipping',
					'magento' => $shipping_mapping['magento_shipping_method'],
					'ebay' => $shipping_mapping['ebay_shipping_method'],			
					);				
				
				//save
				$this->setData($data)->save();				
			}
		}			
	}
	
	protected function savePaymentMapping($data)
	{		
		//Get Resource Model
		$resource_model = $this->getResource();
		
		//Delete old Shipping Mappings
		$collection = $this->getCollection();
		$collection->addFilter('kind','payment');
		foreach ($collection as $colItem)
		{
			       $colItem->delete();
		} 		
		
		//Save
		if (isset($data['payment_method']))
		{
			foreach ($data['payment_method'] as $payment_mapping)
			{
				if ($payment_mapping['delete']=='1') continue;
				
				//Build the data
				$data = array(
					'kind' => 'payment',
					'magento' => $payment_mapping['magento_payment_method'],
					'ebay' => $payment_mapping['ebay_payment_method'],			
					);				
				
				//save
				$this->setData($data)->save();				
			}
		}			
	}	
}
?>
