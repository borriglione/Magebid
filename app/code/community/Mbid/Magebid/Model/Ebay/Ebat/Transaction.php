<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		

/**
 * Mbid_Magebid_Model_Ebay_Ebat_Transaction
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Ebay_Ebat_Transaction extends Mage_Core_Model_Abstract
{
    /**
     * Session-Proxy to send Calls to eBay
     * @var object EbatNs_ServiceProxy
     */	
	protected $_sessionproxy;
	
    /**
     * Old error_reporting()-level
     * @var int
     */	
	protected $_old_error_level;
	
    /**
     * Pagination-Number | 100 entries per page
     * @var int
     */	
	protected $_entries_per_page = 100;	
	
    /**
     * Construct
     * 
     * Save current error_reporting()-level
     * Set error-reporting to 0
     * Define session-Proxy
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_transaction');	
		
		//Set lower Error_Reporting
		$this->_old_error_level = error_reporting();
		error_reporting(E_ERROR | E_PARSE);		
		
		//get Sessionproxy
		$this->_sessionproxy = Mage::getModel('magebid/ebay_ebat_session')->getMagebidConnection();	
    }	
    
    /**
     * Destruct
     * 
     * Reset old error_reporting()-level
     *
     * @return void
     */	
	protected function _destruct() 
	{
		//enable old Error_Reporting
		error_reporting($this->_old_error_level);
	}
	
    /**
     * GetSellerTransactions-Call to get all transaction in a defined data-range
     * 
     * @param string $from Start Date
     * @param string $to End Date
     * @param int $page Pagination
     *
     * @return object
     */	
	public function getSellerTransactions($from,$to,$page)
	{
		$req = new GetSellerTransactionsRequestType();
		
		//Params
		$req->setDetailLevel('ReturnAll');
		
		//Test is Range between ModTimeFrom and ModTimeTo is greater then 30
		if (Mage::helper('magebid')->calculateDaysBetweenTwoDatetimes($from,$to)<30)
		{
			$req->setModTimeFrom($from);
			$req->setModTimeTo($to);
		}
		else
		{
			$req->setNumberOfDays(30);
			Mage::getSingleton('adminhtml/session')->addNotice('The time since the last update is longer then 30 days. Only the transactions of the last 30 days were imported.');
		}
		
		$req->setIncludeContainingOrder(1);	
		
		//Pagination
		$req->Pagination = $this->_pageination($current_page);	

		//Call 
		$res = $this->_sessionproxy->GetSellerTransactions($req);
		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("seller-transactions-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			return $res;
		}		
		else
		{
			//Set Error
			Mage::getModel('magebid/log')->logError("seller-transactions-update","from ".$from." / to ".$to,var_export($req,true),var_export($res,true));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res);
			Mage::getSingleton('adminhtml/session')->addError($message);		
		}			
	}
	
    /**
     * GetOrderTransactions-Call to get the order-informations for the given order_ids
     * 
     * @param array $order_ids eBay-Order-Ids
     *
     * @return object
     */	
	public function getOrderTransactions($order_ids)
	{
		$req = new GetOrderTransactionsRequestType();			
		
		//Params
		$req->setDetailLevel('ReturnAll');		
		
		//Set Order_IDs Array
		$orderIDArray = new OrderIDArrayType();
		foreach ($order_ids as $order_id)
		{
			$orderIDArray->addOrderID($order_id);
		}
		$req->setOrderIDArray($orderIDArray);
		
		//Call 
		$res = $this->_sessionproxy->GetOrderTransactions($req);
		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("order-transactions-update","order_ids ".implode(",",$order_ids),var_export($req,true),var_export($res,true));
			return $res;
		}		
		else
		{
			//Set Error
			Mage::getModel('magebid/log')->logError("order-transactions-update","order_ids ".implode(",",$order_ids),var_export($req,true),var_export($res,true));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}		
	}
	
    /**
     * Map raw eBay Order Item Information for the magebid database
     * 
     * @param OrderType $raw_order eBay-Order-Item
     *
     * @return array
     */	
	public function mapRawOrderItem($raw_order)
	{
		$mapped_order = array(
			'ebay_order_id'=>$raw_order->OrderID,
			'ebay_order_status'=>$raw_order->OrderStatus,
			'payment_method'=>$raw_order->CheckoutStatus->PaymentMethod,
			'payment_status'=>$raw_order->CheckoutStatus->eBayPaymentStatus,
			'checkout_status'=>$raw_order->CheckoutStatus->Status,
		);
		
		return $mapped_order;		
	}

    /**
     * Define Pagination-Settings
     * 
     * @param int $current_page 
     *
     * @return object PaginationType
     */		
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
