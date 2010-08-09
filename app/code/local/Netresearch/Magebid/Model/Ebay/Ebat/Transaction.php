<?php
//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		


class Netresearch_Magebid_Model_Ebay_Ebat_Transaction extends Mage_Core_Model_Abstract
{
	protected $_sessionproxy;
	protected $_old_error_level;
	protected $_auction_data;
	protected $_ebay_item;
	protected $_image_data;
	
	//Pagination
	protected $_entries_per_page = 100;	
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_transaction');	
		
		//Reset error_level
		//disable Error_Reporting
		$this->_old_error_level = error_reporting();
		error_reporting(0);		
		
		//get Sessionproxy
		$this->_sessionproxy = Mage::getModel('magebid/ebay_ebat_session')->getMagebidConnection();	
    }	
	
	protected function _destruct() 
	{
		//enable old Error_Reporting
		error_reporting($this->_old_error_level);
	}
	
	
	public function getItemTransactions($itemid,$transaction_id = "")
	{
		$req = new GetItemTransactionsRequestType(); 
		$req->setItemID($itemid);      				
		if ($transaction_id!="") $req->setTransactionID($transaction_id); 
		$req->setDetailLevel('ReturnAll'); 
		$res = $this->_sessionproxy->GetItemTransactions($req);	
		
		if ($res->Ack == 'Success')
		{					
			Mage::getModel('magebid/log')->logSuccess("transaction-update","itemid ".$itemid." / transaction ".$transaction_id,var_export($req,true),var_export($res,true));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("transaction-update","itemid ".$itemid." / transaction ".$transaction_id,var_export($req,true),var_export($res,true));
			return false;
		}					
	}	
	
	public function getSellerTransactions($from,$to,$page)
	{
		$req = new GetSellerTransactionsRequestType();
		
		//Params
		$req->setDetailLevel('ReturnAll');
		$req->setModTimeFrom($from);
		$req->setModTimeTo($to);	
		$req->setIncludeContainingOrder(1);	
		
		//Pagination
		$req->Pagination = $this->_pageination($current_page);	

		//Call 
		$res = $this->_sessionproxy->GetSellerTransactions($req);
		//print_r($res);
		//exit();			
		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("seller-transactions-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			return $res;
		}		
		else
		{
			//Set Error
			Mage::getModel('magebid/log')->logError("seller-transactions-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res,$itemid);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}			
	}
	
	protected function _pageination($current_page = 1)
	{		
		//Set Pageination
		$pagination = new PaginationType();
		$pagination->setEntriesPerPage($this->_entries_per_page);
		$pagination->setPageNumber($current_page);
		return $pagination;
	}
}
?>
