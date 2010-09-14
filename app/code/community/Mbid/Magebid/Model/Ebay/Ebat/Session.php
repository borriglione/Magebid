<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'EbatNs_ServiceProxy.php';

/**
 * Mbid_Magebid_Model_Ebay_Ebat_Session
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Ebay_Ebat_Session extends Mage_Core_Model_Abstract
{
    /**
     * Session-Proxy-Parameter-Array for the Class EbatNs_Session
     * @var array
     */	  
	private $__params_arr;
	
    /**
     * Session-Proxy to send Calls to eBay
     * @var object EbatNs_ServiceProxy
     */	
	private $__sessionproxy;
	
    /**
     * Construct
	 *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_session');
		
		//Set params array
		$this->_setParamsArray();
    }
    		
    /**
     * Setting Session-Proxy for the eBay-Call
     *
     * @return object
     */	
	public function getMagebidConnection()
	{		
		$session = new EbatNs_Session($this->__params_arr);
		$session->setTokenMode(true);
		$session->setTokenUsePickupFile(false);
		$session->setRequestToken($this->__params_arr['token']);
		$this->__sessionproxy = new EbatNs_ServiceProxy($session);	
		$this->__sessionproxy->setLoggingOptions(array('LOG_TIMEPOINTS'=>false,'LOG_API_USAGE'=>false));
		//$this->__sessionproxy->attachLogger(new EbatNs_Logger(true));
		//$this->__sessionproxy->attachLogger(new EbatNs_Logger(true));
		return $this->__sessionproxy;					
	}	
	
    /**
     * Setting Session-Proxy-Parameters-Array
     *
     * @return void
     */	
	protected function _setParamsArray()
	{
		$this->__params_arr = array(
		'site-id'=>Mage::getSingleton('magebid/setting')->getEbaySiteId(),
		'app-mode'=>Mage::getSingleton('magebid/setting')->getAppMode(),
		'use-http-compression'=>'0',
		'token-mode'=>1,
		'token'=>Mage::getSingleton('magebid/setting')->getToken(),
		'use_standard_logger'=>0
		);				
	}	
	
    /**
     * Preparing the Exception-Handling-Error-Message for Auctions
     * 
     * @param object $res Response-Object of the eBay-Call
     * @param int $ebay_item_id ebay_item_id
     *
     * @return string
     */		
	public function exceptionAuctionHandling($res,$ebay_item_id = "")
	{
		$string = "";
		foreach ($res->Errors as $error)
		{
			$string .= $error->SeverityCode." (".$error->ErrorCode.") ".
						" - ".Mage::helper('magebid')->__('Auction')." ".$ebay_item_id.
						  " - ".$error->ShortMessage.'<br />'.$error->LongMessage."<br />";
		}
		return $string;		
	}	
	
    /**
     * Preparing the Exception-Handling-Error-Message (General)
     * 
     * @param object $res Response-Object of the eBay-Call
     *
     * @return string
     */		
	public function exceptionHandling($res)
	{
		$string = "";
		foreach ($res->Errors as $error)
		{
			$string .= $error->SeverityCode." (".$error->ErrorCode.") ".
						  " - ".$error->ShortMessage.'<br />'.$error->LongMessage."<br />";
		}
		return $string;		
	}		
}
?>
