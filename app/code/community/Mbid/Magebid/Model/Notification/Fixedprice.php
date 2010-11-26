<?php
/**
 * Mbid_Magebid_Model_Notification_Fixedprice
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    Andreas Plieninger <info@plieninger.org>
 * @copyright 2010 Andreas Plieninger
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/


class Mbid_Magebid_Model_Notification_Fixedprice extends Mage_Core_Model_Abstract
{
	/**
     * Construct
     *
     * @return void
     */
	protected function _construct()
    {
        $this->_init('magebid/notification_fixedprice');
    }

	public function handleParsedNotification()
	{
		$getItemResponse = $this->getData('ParsedNotification');
		if(isset($getItemResponse->TransactionArray[0]))
		{
			$getSellerTransaction = $getItemResponse->TransactionArray[0];
			$getSellerTransaction->Item = $getItemResponse->Item;

			Mage::getModel('magebid/transaction')->saveOrUpdate($getSellerTransaction);
		}


		return $this;
	}
}