<?php

class Netresearch_Magebid_Model_Ebay_Transaction extends Mage_Core_Model_Abstract
{
	protected $_handler;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_transaction');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_transaction');
	}
	
	public function getEbayTransaction($ebay_item_id,$transaction_id = "")
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		return $this->_handler->getItemTransactions($ebay_item_id,$transaction_id);
	}	
	
	public function getSellerTransactions($from,$to)
	{		
		$raw_transactions = array();
		$page = 1;

		do
		{			
			$seller_transactions = $this->_handler->getSellerTransactions($from,$to,$page);	
			
			foreach ($seller_transactions->TransactionArray as $raw_transaction)
			{
				$raw_transactions[] = $raw_transaction;
			}			
			$page++;

			//Daily Log
			Mage::getModel('magebid/daily_log')->logCall();				
		} 
		while ($page<=$seller_transactions->PaginationResult->TotalNumberOfPages);	
		
		return $raw_transactions;
	}
}

?>
