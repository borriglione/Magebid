<?php
/**
 * Netresearch_Magebid_Model_Daily_Log
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Daily_Log extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/daily_log');
    }
    
    /**
     * Log a call for the current day
     * 
     * If there are already calls stored for the current day, increase the number of calls for this days by 1
     * If nere are no calls for the current day, add a new entry with the count 1
     *
     * @return void
     */	
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
