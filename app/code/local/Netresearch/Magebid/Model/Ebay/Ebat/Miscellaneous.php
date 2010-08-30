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
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
		error_reporting(E_ERROR | E_WARNING | E_PARSE);	
		
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
     * GeteBayDetails-Call to import f.e. Shipping and Payment Informations
     * 
     * @param string $DetailName Import-Task
     *
     * @return object
     */	
	public function geteBayDetails($DetailName)
	{
		$req = new GeteBayDetailsRequestType();
		if (!empty($DetailName)) $req->setDetailName($DetailName);
		$res = $this->_sessionproxy->GeteBayDetails($req);
		
		if ($res->Ack == 'Success')
		{			
			Mage::getModel('magebid/log')->logSuccess("import",$DetailName,Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($req),Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($res));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import",$DetailName,Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($req),Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($res));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}			
	}

    /**
     * GetCategories-Call to import categories
     * 
     * @param boolean $return_all Return all Details
     *
     * @return object
     */		
	public function geteBayCategories($return_all = false)
	{
		$req = new GetCategoriesRequestType();
		if ($return_all) $req->setDetailLevel('ReturnAll');
		$res = $this->_sessionproxy->GetCategories($req);
		
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("import","Category",Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($req));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import","Category",Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($req),Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($res));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}			
	}	
	
    /**
     * GetCategoryFeatures-Call to import category-features
     * 
     * @param boolean $return_all Return all Details
     *
     * @return object
     */		
	public function getCategoryFeatures($return_all = false)
	{
		//Build Request
		$req = new GetCategoryFeaturesRequestType();
		if ($return_all) $req->setDetailLevel('ReturnAll');
		$req->setViewAllNodes(1);
		
		//Submit Request
		$res = $this->_sessionproxy->GetCategoryFeatures($req);
		
		//Wort with response
		if ($res->Ack == 'Success')
		{
			Mage::getModel('magebid/log')->logSuccess("import","Category Features",Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($req));
			return $res;
		}
		else
		{
			Mage::getModel('magebid/log')->logError("import","Category Features",Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($req),Mage::helper('coding')->encodeXmlEbayToMagentoAndDump($res));
			$message = Mage::getSingleton('magebid/ebay_ebat_session')->exceptionHandling($res);
			Mage::getSingleton('adminhtml/session')->addError($message);	
		}			
	}
}
?>
