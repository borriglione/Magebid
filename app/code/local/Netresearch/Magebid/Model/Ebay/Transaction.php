<?php
/**
 * Netresearch_Magebid_Model_Ebay_Transaction
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Ebay_Transaction extends Mage_Core_Model_Abstract
{
    /**
     * Handler for Calls to eBay
     * @var object Netresearch_Magebid_Model_Ebay_Ebat_Transaction
     */		
	protected $_handler;
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/ebay_transaction');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_transaction');
	}	
	
    /**
     * Get all Seller Transactions in the date range $from->$to
     *
     * @param string $from Start Date
     * @param string $to End Date
     *
     * @return array
     */		
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
