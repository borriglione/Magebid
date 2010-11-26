<?php
/**
 * Mbid_Magebid_Model_Ebay_Sale
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Ebay_Sale extends Mage_Core_Model_Abstract
{
    /**
     * Handler for Calls to eBay
     * @var object Mbid_Magebid_Model_Ebay_Ebat_Sale
     */
	protected $_handler;

    /**
     * Construct
     *
     * @return void
     */
	protected function _construct()
    {
        $this->_init('magebid/ebay_sale');

		//set Request Handler
		$this->_handler = Mage::getModel('magebid/ebay_ebat_sale');
    }

    /**
     * Change Status of Orders in eBay
     *
     * @param object $transaction Mbid_Magebid_Model_Transaction
     * @param string $tasks Which feedbacks should be given f.e. 'payment_received'
     *
     * @return object
     */
	public function setCompleteSale($transaction,$tasks)
	{
		//Daily Log
		Mage::getModel('magebid/daily_log')->logCall();

		//@TODO TODO	for live production disabled in testing mode!
		//return $this->_handler->setCompleteSale($transaction,$tasks);
	}

}
?>
