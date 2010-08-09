<?php
class Netresearch_Magebid_Helper_Order_Data extends Mage_Core_Helper_Abstract
{
	public function getSplitedFirstname($name)
	{
		$splited_name = explode(" ",$name);
		unset($splited_name[count($splited_name)-1]);
		return implode(" ",$splited_name);
	}
	
	public function getSplitedLastname($name)
	{
		$splited_name = explode(" ",$name);
		return $splited_name[count($splited_name)-1];
	}	
	
	public function _compareCustomerAddress($customer,$shipping_address_data)
	{
    	$addresses = $customer->getAddresses();
    	foreach ($addresses as $address)
		{
    		$address_data = $address->getData();
    		unset($address_data['entity_id']);
    		unset($address_data['entity_type_id']);
    		unset($address_data['attribute_set_id']);
    		unset($address_data['increment_id']);
    		unset($address_data['parent_id']);
    		unset($address_data['store_id']);
    		unset($address_data['created_at']);
    		unset($address_data['updated_at']);    		
    		unset($address_data['is_active']);
						
    		if ( !array_diff($shipping_address_data, $address_data) ) {
    			return $address;
    		}
		}	
		
		return false;	
	}
	

}
?>