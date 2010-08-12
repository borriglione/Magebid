<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'EbatNs_ServiceProxy.php';



class Netresearch_Magebid_Model_Ebay_Ebat_Session extends Mage_Core_Model_Abstract
{
    var $connection;
	private $__params_arr;
	private $__sessionproxy;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_session');
		
		//Set params array
		$this->_setParamsArray();
    }	
	
	
	
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
	
	
	
	protected function _setParamsArray()
	{
		$params_arr = array(
		/*
		'sandbox'=>
				array(
					'AppId'=>Mage::getSingleton('magebid/setting')->getSandboxAppKey(),
					'DevId'=>Mage::getSingleton('magebid/setting')->getSandboxDevKey(),
					'CertId'=>Mage::getSingleton('magebid/setting')->getSandboxCertId(),
				),
		'production'=>
				array(
					'AppId'=>Mage::getSingleton('magebid/setting')->getProductionAppKey(),
					'DevId'=>Mage::getSingleton('magebid/setting')->getProductionDevKey(),
					'CertId'=>Mage::getSingleton('magebid/setting')->getProductionCertId(),			
				),
		*/
		'site-id'=>Mage::getSingleton('magebid/setting')->getEbaySiteId(),
		'app-mode'=>Mage::getSingleton('magebid/setting')->getAppMode(),
		'use-http-compression'=>'0',
		'token-mode'=>1,
		'token'=>Mage::getSingleton('magebid/setting')->getToken(),
		'use_standard_logger'=>0
		);		
		
		
		$this->__params_arr = $params_arr;		
	}	
	
	public function exceptionHandling($res,$ebay_item_id)
	{
		$string = "";
		foreach ($res->Errors as $error)
		{
			$string .= $error->SeverityCode." (".$error->ErrorCode.") ".
						" - ".Mage::helper('magebid')->__('Auction')." ".$ebay_item_id.
						  " - ".Mage::helper('coding')->encodePrepareDb(htmlentities($error->ShortMessage)).'<br />'.Mage::helper('coding')->encodePrepareDb(htmlentities($error->LongMessage))."<br />";
		}
		return $string;		
	}	
}
?>
