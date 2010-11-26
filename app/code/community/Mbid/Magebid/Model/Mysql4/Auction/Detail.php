<?php
/**
 * Mbid_Magebid_Model_Mysql4_Auction_Detail
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Mysql4_Auction_Detail extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Construct
     *
     * @return void
     */
	protected function _construct()
    {
        $this->_init('magebid/auction_detail', 'magebid_auction_detail_id');
    }

	/**
	 * return the oldest date of the db field last_update, where auction is active
	 *
	 * @return string date
	 */
    public function getOldestLastUpdated() {
    	$select = $this->_getReadAdapter()
				->select()
				->from($this->getMainTable(),'min('.$this->getMainTable().'.last_updated) as min_last_updated')
				->join(
	                array('ma' => $this->getTable('magebid/auction')),
	                $this->getMainTable().'.magebid_auction_detail_id = ma.magebid_auction_detail_id')
	            ->where('magebid_ebay_status_id = ?',Mbid_Magebid_Model_Auction::AUCTION_STATUS_ACTIVE)
	            ->group('magebid_ebay_status_id');
		$data = $this->_getReadAdapter()->fetchAll($select);

        if (!empty($data) && $data[0]['min_last_updated']!="")
        {
        	return $data[0]['min_last_updated'];
        }
        return false;
    }
}
?>
