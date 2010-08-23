<?php
/**
 * Netresearch_Magebid_Model_Ebay_Store
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Ebay_Store extends Mage_Core_Model_Abstract
{
    /**
     * Handler for Calls to eBay
     * @var object Netresearch_Magebid_Model_Ebay_Ebat_Store
     */	
	protected $_handler;
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/ebay_store');
		
		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_store');
    }		
	
    /**
     * Get all eBay Store Categories
     *
     * @return array
     */		
	public function geteBayStoreCategories()
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();			
		
		if ($res = $this->_handler->getStore())
		{				
			return $res->Store->CustomCategories;
		}
	}	
}
?>
