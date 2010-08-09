<?php
//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'CompleteSaleRequestType.php';


class Netresearch_Magebid_Model_Ebay_Ebat_Sale extends Mage_Core_Model_Abstract
{
	protected $_sessionproxy;
	var $old_error_level;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_sale');	
		
		//Reset error_level && disable Error_Reporting
		$this->old_error_level = error_reporting();
		error_reporting(0);		
		
		//get Sessionproxy
		$this->_sessionproxy = Mage::getModel('magebid/ebay_ebat_session')->getMagebidConnection();	
    }	
	
	protected function _destruct() 
	{
		//enable old Error_Reporting
		error_reporting($this->old_error_level);
	}
	
	public function setCompleteSale($transaction,$tasks)
	{
		$req = new CompleteSaleRequestType();   

		//set ebay_item_id
        $req->setItemID($transaction->getEbayItemId());
        
        //if there is a transaction_id, set it
        if ($transaction->getEbayTransactionId()!="") $req->setTransactionID($transaction->getEbayTransactionId());	
		
        //if there is an order_id, set it
        if ($transaction->getEbayOrderId()!="") $req->setOrderID($transaction->getEbayOrderId());	
        
		//Feedback
		if (isset($tasks['feedback']))
		{
			$feedback = new FeedbackInfoType();
			$feedback->setCommentText($tasks['feedback']['text']);
			$feedback->setCommentType('Positive');		
		    $feedback->setTargetUser($tasks['feedback']['user']);
			$req->setFeedbackInfo($feedback);			
		}
		
		//Paid
		if (isset($tasks['paid'])) $req->setPaid(1);	
		
		//Shipped
		if (isset($tasks['shipped'])) $req->setShipped(1);
			
        $res = $this->_sessionproxy->CompleteSale($req);
        	
		if ($res->Ack == 'Success')
		{			
			Mage::getModel('magebid/log')->logSuccess("transaction-status-change","itemid ".$item_id." / transaction ".$transaction_id,var_export($req,true),var_export($res,true),var_export($tasks,true));
			return true;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("transaction-status-change","itemid ".$item_id." / transaction ".$transaction_id,var_export($req,true),var_export($res,true),var_export($tasks,true));
			return false;
		}		
	}			
}
?>
