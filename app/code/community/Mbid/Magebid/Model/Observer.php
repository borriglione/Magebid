<?php
/**
 * Mbid_Magebid_Model_Observer
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Observer
{
    /**
     * Update Auctions
     *
     * @param  Varien_Event_Observer | Mage_Cron_Model_Schedule $observer
     * @return Mbid_Magebid_Model_Observer $this
     */
    public function updateAuctions($observer = null)
    {
        if (Mage::getStoreConfig('magebid/synchronisation/auction')):
            Mage::getModel('magebid/auction')->updateAuctions();
        endif;
        return $this;
    }
 
    /**
     * Update Transactions
     *
     * @param  Varien_Event_Observer | Mage_Cron_Model_Schedule $observer
     * @return Mbid_Magebid_Model_Observer $this
     */
    public function updateTransactions($observer = null)
    {
        if (Mage::getStoreConfig('magebid/synchronisation/transaction')):
            Mage::getModel('magebid/auction')->updateTransactions();
        endif;
        return $this;
    }
}
?>