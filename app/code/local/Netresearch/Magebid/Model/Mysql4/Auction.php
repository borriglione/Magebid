<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Auction
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Mysql4_Auction extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/auction', 'magebid_auction_id');
    }	

    /**
     * When loading the auction, load shipping,payment and listing_enhancement too
     * 
     * @param object $object
     *
     * @return object
     */	   
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        //Load payment		
		$select = $this->_getReadAdapter()->select()
            ->from($this->getTable('magebid/payments'))
            ->where('magebid_auction_id = ?', $object->getMagebidAuctionId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $paymentsArray = array();
            foreach ($data as $row) {
                $paymentsArray[] = array('payment_method'=>$row['code']);
            }
            $object->setData('payment_methods', $paymentsArray);
        }
		
		//Load shipping
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('magebid/shipping'))
            ->where('magebid_auction_id = ?', $object->getMagebidAuctionId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $shippingArray = array();
            foreach ($data as $row) {
                $shippingArray[] = array('shipping_method'=>$row['code'],'price'=>$row['price'],'add_price'=>$row['add_price']);
            }
            $object->setData('shipping_methods', $shippingArray);
        }		
		
		//Load listing enhancement
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('magebid/listing_enhancement'))
            ->where('magebid_auction_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $listingEnhancementArray = array();
            foreach ($data as $row) {
                $listingEnhancementArray[] = $row['code'];
            }
            $object->setData('listing_enhancement', $listingEnhancementArray);
        }				
		

        return parent::_afterLoad($object);
    }	

    /**
     * Manipulating Load SQL, Join Table ebay_status,auction_details and auction_type
     *
     * @return void
     */    
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
		
		//Joins
        $select->join(
				array('mes' => $this->getTable('magebid/ebay_status')),
				 $this->getMainTable().'.magebid_ebay_status_id = mes.magebid_ebay_status_id')
		       ->join(
                array('mad' => $this->getTable('magebid/auction_detail')), 
                $this->getMainTable().'.magebid_auction_detail_id = mad.magebid_auction_detail_id')				 
 		       ->join(
                array('mat' => $this->getTable('magebid/auction_type')), 
                $this->getMainTable().'.magebid_auction_type_id = mat.magebid_auction_type_id');		 							     
        return $select;
    }	
	
    /**
     * After deleting the auction data, delete the shipping,payment and listing_enhancement too
     * 
     * @param object $object Profile Object
     *
     * @return void
     */		    
	protected function _afterDelete(Mage_Core_Model_Abstract $object)
	{
			//Delete Shipping
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_auction_id = ?', $object->getId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/shipping'), $condition);	
			
			//Delete payment
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_auction_id = ?', $object->getId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/payments'), $condition);	
			
			//Delete Listing Enhancement
      		$condition = $this->_getWriteAdapter()->quoteInto('magebid_auction_id = ?', $object->getId());
            $this->_getWriteAdapter()->delete($this->getTable('magebid/listing_enhancement'), $condition);				
			
			//Delete auction_details
	        Mage::getModel('magebid/auction_detail')->setId($object->getMagebidAuctionDetailId())->delete();				
	}	
	
    /**
     * After saving aution, save shipping and payment methods as well
     * 
     * @param object $object Profile Object
     *
     * @return void
     */	    	
    public function save(Mage_Core_Model_Abstract $object)
    {    	
		$this->beginTransaction();
		
		try
		{
			//Save main object			
			parent::save($object);
			
			if ($object->getRequestType()!='export' && $object->getRequestType()!='update')
			{
				//Save auction details
				$this->_prepareAuctionDetailsData($object);
				Mage::getModel('magebid/auction_detail')
					->load($object->getMagebidAuctionDetailId())
					->addData($object->getData())
					->save();
			
			
				//Save payment
				$this->_savePayment($object);
	
				//Save shipping
				$this->_saveShipping($object);					
			}						
			
			$this->commit();				
		}		
		catch (Exception $e) 
		{			
			$this->rollBack();
			throw($e);
		}		
	}

    /**
     * Save Payment Methods for auction
     * 
     * @param object $object Auction Object
     *
     * @return void
     */	 		
	protected function _savePayment($object)
	{
			//Delete old payment
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_auction_id = ?', $object->getId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/payments'), $condition);		
			
			//Save Payment Data
			$payment_methods = $object->getPaymentMethod();		
			
			foreach ($payment_methods as $value)
			{
				if ($value['delete']!=1)
				{				
					$data = array(
						'magebid_auction_id' =>$object->getId(),
						'code' => $value['payment_method'],		 
						);
						
						Mage::getModel('magebid/payments')
								->setData($data)
									->save();
				}
				else
				{
					
				}
			}	
	}
	
    /**
     * Save Shipping Methods for auction
     * 
     * @param object $object Auction Object
     *
     * @return void
     */	 	
	protected function _saveShipping($object)
	{
			//Delete old Shipping
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_auction_id = ?', $object->getId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/shipping'), $condition);		
			
			//Save Shipping Data
			$shipping_methods = $object->getShippingMethod();		
			
			foreach ($shipping_methods as $value)
			{
				if ($value['delete']!=1)
				{
					$data = array(
						'magebid_auction_id' =>$object->getId(),
						'code' => $value['shipping_method'],
						'price' => $value['price'],	
						'add_price' => $value['add_price'],					 
						);
						
						Mage::getModel('magebid/shipping')
								->setData($data)
									->save();
				}
			}		
	}
	
    /**
     * Save Listing Enhancements (Layoutoptionen)
     * 
     * @param object $object Auction Object
     *
     * @return object
     */	 		
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('magebid_auction_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('magebid/listing_enhancement'), $condition);

		if ($object->getData('listing_enhancement'))
		{
	        foreach ($object->getData('listing_enhancement') as $listing_enhancement) {
	        	if ($listing_enhancement=="") continue;
	            $listing_enhancement_data = array();
	            $listing_enhancement_data['magebid_auction_id'] = $object->getId();
	            $listing_enhancement_data['code'] = $listing_enhancement;
	            $this->_getWriteAdapter()->insert($this->getTable('magebid/listing_enhancement'), $listing_enhancement_data);			
	        }			
		}

        return parent::_afterSave($object);
    }	
    			
    /**
     * Prepare Start-Date and End-Date for auction detail data
     * 
     * Possibility of wrong behaviour, see Jira NRMB-91
     * 
     * @param object $object Auction Object
     *
     * @return void
     */	 		
	protected function _prepareAuctionDetailsData($object)
	{
		//calculate Auction Life Time
		$start_date = $object->getStartDate();
		$end_date = $object->getEndDate();
		$life_time = $object->getLifeTime();

		if (!empty($start_date))
		{
			$start_date = $this->_formatDateTime($start_date);
			$object->setStartDate($start_date);
			$object->setEndDate($this->_getEndDate($start_date,$life_time));
		}
		else
		{
			$object->setStartDate(NULL);
			$object->setEndDate(NULL);			
		}		
	}
	
    /**
     * Format Date Time 
     * 
     * Candidate for moving this function into the Magebid Helper
     * 
     * @param string $date
     *
     * @return string
     */		
	protected function _formatDateTime($date)
	{
		$format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$date = Mage::app()->getLocale()->date($date, $format);
		$time = $date->getTimestamp();
		return Mage::getModel('core/date')->gmtDate(null, $time);
	}	
	
    /**
     * Calculating End Date
     * 
     * @param string $start_date
     * @param int life_time In days 
     *
     * @return string
     */			
	protected function _getEndDate($start_date,$life_time)
	{
		$time = Mage::getModel('core/date')->timestamp($start_date);
		$time = $time+(60*60*24*$life_time);
		return Mage::getModel('core/date')->gmtDate(null, $time);
	}	
	
    /**
     * Get different statused from the table ebay_status
     * 
     * Delete candidate, see NRME89
     * 
     * @return array
     */			
	public function getEbayStatuses()
	{
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('magebid/ebay_status'));
			
		if ($data = $this->_getReadAdapter()->fetchAll($select))
		{			
			return $data;
		}	 	
	}		

    /**
     * Get oldest Start-Date, used for the eBay-Call getSellerList
     * 
     * @return string
     */		
	public function getOldestStartDate()
	{
		$select = $this->_getReadAdapter()
			->select()
			->from($this->getMainTable())
			->columns('min(mad.start_date) as min_start_date,min('.$this->getMainTable().'.date_created) as min_date_created')            
		    ->join(
                array('mad' => $this->getTable('magebid/auction_detail')), 
                $this->getMainTable().'.magebid_auction_detail_id = mad.magebid_auction_detail_id')	                          	
            ->where('magebid_ebay_status_id = ?',Netresearch_Magebid_Model_Auction::AUCTION_STATUS_ACTIVE)
            ->group('magebid_ebay_status_id'); 
       
        $data = $this->_getReadAdapter()->fetchAll($select);
        
        if (!empty($data))
        {
        	if ($data[0]['min_start_date']!="") return $data[0]['min_start_date'];
        	else return $data[0]['min_date_created'];
        }      
	}
}
?>
