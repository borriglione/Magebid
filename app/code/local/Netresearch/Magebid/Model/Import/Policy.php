<?php
class Netresearch_Magebid_Model_Import_Policy extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/import_policy');
    }	
	
	public function importEbayPolicies()
	{
		//Import Return Policy
		return $this->_importReturnPolicy();
	}
	
	protected function _importReturnPolicy()
	{
		//Import Policies
		$ebay_return_policies = Mage::getModel('magebid/ebay_miscellaneous')->geteBayDetails('ReturnPolicyDetails');
		
		//delete all existing Refunds
		$collection = $this->getCollection();		
		$collection->addFieldToFilter('main_table.key','RefundOption');	
		//Mage::debug($collection->getSelect()->__toString());	
		foreach ($collection as $colItem){
			       $colItem->delete();
		} 		
		
		//Add the new Refunds
		foreach ($ebay_return_policies->ReturnPolicyDetails->Refund as $refund)
		{
			//Build the data
			$data = array(
				'key' => "RefundOption",
				'value' => $refund->RefundOption,	
				'description' => $refund->Description,		
				);				
			
			//save
			$this->setData($data)->save();
		}	
		
		
		//delete all existing Refunds
		$collection = $this->getCollection();
		$collection->addFieldToFilter('main_table.key','ReturnsAcceptedOption');		
		foreach ($collection as $colItem){
			       $colItem->delete();
		} 		
		
		//Add the new Refunds
		foreach ($ebay_return_policies->ReturnPolicyDetails->ReturnsAccepted as $refund_accepted)
		{
			//Build the data
			$data = array(
				'key' => "ReturnsAcceptedOption",
				'value' => $refund_accepted->ReturnsAcceptedOption,	
				'description' => Mage::helper('coding')->importEncodeString($refund_accepted->Description),		
				);				
			
			//save
			$this->setData($data)->save();
		}		
				
		return count($ebay_return_policies->ReturnPolicyDetails->Refund);
	}
	
	
	public function getRefundOption()
	{
		$collection = $this->getCollection();		
		$collection->addFieldToFilter('main_table.key','RefundOption');	
		$collection = $collection->transformToOptionArray('value','value');
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));		
		return $collection;					
	}	
	
	public function getReturnsAcceptedOption()
	{
		$collection = $this->getCollection();		
		$collection->addFieldToFilter('main_table.key','ReturnsAcceptedOption');	
		$collection = $collection->transformToOptionArray('value','value');
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));		
		return $collection;	
	}
	
}
?>
