<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Shipping
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Mysql4_Profile extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/profile/', 'magebid_profile_id');
    }	

    /**
     * After saving profile, save shipping and payment methods as well
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
			
			//Save payment
			$magebid_payment_methods = $this->_savePayment($object);

			//Save shipping
			$magebid_shipping_methods = $this->_saveShipping($object);			
			
			$this->commit();				
		}		
		catch (Exception $e) 
		{			
			$this->rollBack();
			throw($e);
		}		
	}	
	
    /**
     * Save Payment Methods for profile
     * 
     * @param object $object Profile Object
     *
     * @return void
     */	 	
	protected function _savePayment($object)
	{
			//Delete old payment
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_profile_id = ?', $object->getMagebidProfileId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/payments'), $condition);		
			
			//Save Payment Data
			$payment_methods = $object->getPaymentMethod();		
			
			foreach ($payment_methods as $value)
			{
				if ($value['delete']!=1)
				{				
					$data = array(
						'magebid_profile_id' =>$object->getMagebidProfileId(),
						'code' => $value['payment_method'],
						);
						
						Mage::getModel('magebid/payments')
								->setData($data)
									->save();
				}
			}	
	}
	
    /**
     * Save Shipping Methods for profile
     * 
     * @param object $object Profile Object
     *
     * @return void
     */	 	
	protected function _saveShipping($object)
	{
			//Delete old Shipping
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_profile_id = ?', $object->getMagebidProfileId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/shipping'), $condition);		
			
			//Save Shipping Data
			$shipping_methods = $object->getShippingMethod();		
			
			foreach ($shipping_methods as $value)
			{
				if ($value['delete']!=1)
				{
					$data = array(
						'magebid_profile_id' =>$object->getMagebidProfileId(),
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
     * @param object $object Profile Object
     *
     * @return object
     */	 	
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('magebid_profile_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('magebid/listing_enhancement'), $condition);

		if ($object->getData('listing_enhancement'))
		{       
			foreach ($object->getData('listing_enhancement') as $listing_enhancement) {
				if ($listing_enhancement=="") continue;
	            //echo $listing_enhancement;
				$listing_enhancement_data = array();
	            $listing_enhancement_data['magebid_profile_id'] = $object->getId();
	            $listing_enhancement_data['code'] = $listing_enhancement;
	            $this->_getWriteAdapter()->insert($this->getTable('magebid/listing_enhancement'), $listing_enhancement_data);			
	        }						
		}

        return parent::_afterSave($object);
    }	
	
    /**
     * After deleting the profile data, delete the shipping,payment and listing_enhancement too
     * 
     * @param object $object Profile Object
     *
     * @return void
     */		
	protected function _afterDelete(Mage_Core_Model_Abstract $object)
	{
			//Delete Shipping
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_profile_id = ?', $object->getMagebidProfileId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/shipping'), $condition);	
			
			//Delete payment
	        $condition = $this->_getWriteAdapter()->quoteInto('magebid_profile_id = ?', $object->getMagebidProfileId());
	        $this->_getWriteAdapter()->delete($this->getTable('magebid/payments'), $condition);		
			
			//Delete Listing Enhancement
      		$condition = $this->_getWriteAdapter()->quoteInto('magebid_profile_id = ?', $object->getId());
            $this->_getWriteAdapter()->delete($this->getTable('magebid/listing_enhancement'), $condition);				
	}	
	
    /**
     * When loading the profile, load shipping,payment and listing_enhancement too
     * 
     * @param object $object Profile Object
     *
     * @return object
     */		
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        //Load payment		
		$select = $this->_getReadAdapter()->select()
            ->from($this->getTable('magebid/payments'))
            ->where('magebid_profile_id = ?', $object->getMagebidProfileId());

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
            ->where('magebid_profile_id = ?', $object->getMagebidProfileId());

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
            ->where('magebid_profile_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $listingEnhancementArray = array();
            foreach ($data as $row) {
                $listingEnhancementArray[] = $row['code'];
            }
            $object->setData('listing_enhancement', $listingEnhancementArray);
        }		
		

        return parent::_afterLoad($object);
    }	
	
				
}
?>
