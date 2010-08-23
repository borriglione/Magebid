<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		

/**
 * Netresearch_Magebid_Model_Ebay_Ebat_Transaction
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Ebay_Ebat_Transaction extends Mage_Core_Model_Abstract
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
		
		//Reset error_level
		//disable Error_Reporting
		$this->_old_error_level = error_reporting();
		error_reporting(0);		
		
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
