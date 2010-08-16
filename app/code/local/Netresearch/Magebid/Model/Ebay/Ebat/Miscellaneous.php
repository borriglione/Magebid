<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'GetItemRequestType.php';;
require_once 'GeteBayOfficialTimeRequestType.php';
require_once 'GeteBayOfficialTimeResponseType.php';
require_once 'GetCategoriesRequestType.php';
require_once 'GetCategoriesResponseType.php';

/**
 * Netresearch_Magebid_Model_Ebay_Ebat_Miscellaneous
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Ebay_Ebat_Miscellaneous extends Mage_Core_Model_Abstract
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
        $this->_init('magebid/ebay_ebat_miscellaneous');	
		
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
	
	/*
	public function getEbayTime()
	{
		$req = new GeteBayOfficialTimeRequestType();       				
		$res = $this->_sessionproxy->GeteBayOfficialTime($req);
		return $res->Timestamp;	
	}	
	*/	
	
	public function geteBayDetails($DetailName)
	{
		$req = new GeteBayDetailsRequestType();
		if (!empty($DetailName)) $req->setDetailName($DetailName);
		$res = $this->_sessionproxy->GeteBayDetails($req);
		
		if ($res->Ack == 'Success')
		{			
			Mage::getModel('magebid/log')->logSuccess("import",$DetailName,var_export($req,true),var_export($res,true));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import",$DetailName,var_export($req,true),var_export($res,true));
			throw new Exception($res->Errors[0]->ShortMessage.'<br />'.$res->Errors[0]->LongMessage);
		}			
		
		return $res;		
	}
	
	public function geteBayCategories($detail_level = '',$limit = '')
	{
		$req = new GetCategoriesRequestType();
		if ($detail_level!="") $req->setDetailLevel('ReturnAll');
		if ($limit!="") $req->setLevelLimit(0);
		$res = $this->_sessionproxy->GetCategories($req);
		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("import","Category",var_export($req,true));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import","Category",var_export($req,true),var_export($res,true));
			throw new Exception($res->Errors[0]->ShortMessage.'<br />'.$res->Errors[0]->LongMessage);
		}			
		
		return $res;		
	}	
	
	public function getCategoryFeatures($detail_level = '')
	{
		//Build Request
		$req = new GetCategoryFeaturesRequestType();
		if ($detail_level!="") $req->setDetailLevel('ReturnAll');
		$req->setViewAllNodes(1);
		
		//$req->setCategoryID(9355);
		
		//Submit Request
		$res = $this->_sessionproxy->GetCategoryFeatures($req);
		
		//Wort with response
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("import","Category Features",var_export($req,true));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import","Category Features",var_export($req,true),var_export($res,true));
			throw new Exception($res->Errors[0]->ShortMessage.'<br />'.$res->Errors[0]->LongMessage);
		}			
		
		return $res;				
	}
}
?>
