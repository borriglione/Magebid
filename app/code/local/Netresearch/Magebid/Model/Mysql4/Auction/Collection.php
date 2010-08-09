<?php
class Netresearch_Magebid_Model_Mysql4_Auction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_magebidTable;
	protected $_joinFlags = array();

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magebid/auction');
	}
	
    public function joinFields()
    {
		$this->getSelect()
            ->join(
                array('mes' => $this->getTable('magebid/ebay_status')), 
                'mes.magebid_ebay_status_id = main_table.magebid_ebay_status_id')
		    ->join(
                array('mad' => $this->getTable('magebid/auction_detail')), 
                'mad.magebid_auction_detail_id = main_table.magebid_auction_detail_id')	
		    ->join(
                array('mat' => $this->getTable('magebid/auction_type')), 
                'mat.magebid_auction_type_id = main_table.magebid_auction_type_id');					
		//echo $this->getSelect()->__toString();
    }
	
	
}
?>