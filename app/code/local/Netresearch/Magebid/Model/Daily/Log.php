<?php
class Netresearch_Magebid_Model_Daily_Log extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('magebid/daily_log');
    }
    
    public function logCall()
    {
    	$today = Mage::getModel('core/date')->gmtDate('Y-m-d'); 
    	
    	if ($this->load($today,'day')->getId())
    	{
    		$calls_today = $this->getCount();
    		$this->setCount($calls_today+1)->save();    		
    	}
    	else
    	{
    		$this->setData(array('day'=>$today,'count'=>1))->save();
    	}
    }
}
?>
