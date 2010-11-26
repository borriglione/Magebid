<?php
/**
 * Mbid_Magebid_Model_Mapping
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Mapping extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/mapping');
    }	
	
    /**
     * Save Shipping and Payment Mappings
     *
     * @param array $data Magento Request Data
     *
     * @return void
     */	     
	public function saveMapping($data)
	{
		//Save Shipping Mapping
		$this->saveShippingMapping($data);		
		
		//Save Payment Mapping
		$this->savePaymentMapping($data);
	}
	
    /**
     * Save Shipping Mappings
     *
     * @param array $data Magento Request Data
     *
     * @return void
     */	   
	protected function saveShippingMapping($data)
	{	
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
				//Don't save deleted shipping methods
				if ($shipping_mapping['delete']=='1') continue; 
				
				//Build the data
				$data = array(
					'kind' => 'shipping',
					'magento' => $shipping_mapping['magento_shipping_method'],
					'ebay' => $shipping_mapping['ebay_shipping_method'],			
					);				
				
				//save mapping
				$this->setData($data)->save();				
			}
		}			
	}
	
    /**
     * Save Payment Mappings
     *
     * @param array $data Magento Request Data
     *
     * @return void
     */	  	
	protected function savePaymentMapping($data)
	{		
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
				//Don't save deleted payment methods
				if ($payment_mapping['delete']=='1') continue;
				
				//Build the data
				$data = array(
					'kind' => 'payment',
					'magento' => $payment_mapping['magento_payment_method'],
					'ebay' => $payment_mapping['ebay_payment_method'],			
					);				
				
				//save mapping
				$this->setData($data)->save();				
			}
		}			
	}	
}
?>
