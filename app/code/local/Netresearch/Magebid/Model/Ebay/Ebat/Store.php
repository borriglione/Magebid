<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'GetStoreRequestType.php';

/**
 * Netresearch_Magebid_Model_Ebay_Ebat_Store
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Ebay_Ebat_Store extends Mage_Core_Model_Abstract
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
        $this->_init('magebid/ebay_ebat_store');	
		
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
	
	public function getStore()
	{
		$req = new GetStoreRequestType();
		$res = $this->_sessionproxy->GetStore($req);
		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("import","Store-Category",var_export($req,true));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import","Store-Category",var_export($req,true),var_export($res,true));
			throw new Exception($res->Errors[0]->ShortMessage.'<br />'.$res->Errors[0]->LongMessage);
		}			
		
		return $res;		
	}	
}
?>
