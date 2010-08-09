<?php
//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';		
require_once 'GetStoreRequestType.php';

class Netresearch_Magebid_Model_Ebay_Ebat_Store extends Mage_Core_Model_Abstract
{
	protected $_sessionproxy;
	var $old_error_level;
	
	protected function _construct()
    {
        $this->_init('magebid/ebay_ebat_store');	
		
		//Reset error_level
		//disable Error_Reporting
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
