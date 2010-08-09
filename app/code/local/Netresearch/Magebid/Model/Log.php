<?php
class Netresearch_Magebid_Model_Log extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('magebid/log');
    }
    
    public function logSuccess($type,$title,$request,$response="",$additional="")
    {
    	if (Mage::getStoreConfig('magebid/magebid_log/success')) $this->logging($type,$title,$request,$response,$additional,"success");
    }
    
    public function logWarning($type,$title,$request,$response="",$additional="")
    {
    	if (Mage::getStoreConfig('magebid/magebid_log/warning')) $this->logging($type,$title,$request,$response,$additional,"warning");
    }

    public function logError($type,$title,$request,$response="",$additional="")
    {
    	if (Mage::getStoreConfig('magebid/magebid_log/error')) $this->logging($type,$title,$request,$response,$additional,"error");
    }    
    
    protected function logging($type,$title,$request,$response,$additional,$result)
    {
     	$log_data = array(
			'type' => $type,
			'title' => $title,
			'request' => $request,
     		'response' => $response,
     		'additional' => $additional,
			'result' => $result,
    		'date_created' => date('Y-m-d H:i:s')
		);		
    	
    	$this->addData($log_data);		
	    $this->save();   	
    }
}
?>
