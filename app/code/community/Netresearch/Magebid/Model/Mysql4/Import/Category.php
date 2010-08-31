<?php
/**
 * Netresearch_Magebid_Model_Mysql4_Import_Category
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Mysql4_Import_Category extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/import_category', 'magebid_import_category_id');
    }	
	
    /**
     * Special Function to get the eBay-Store-Categories
     * 
     * @param object $object
     * @param string $value 
     *
     * @return object
     */	 	   
	public function loadByStore($object, $value)
	{
		 $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where($this->getMainTable().'.category_id=?', $value)
			->where($this->getMainTable().'.store=?', '1');		
			
         $read = $this->_getReadAdapter();
		 
		 $data = $read->fetchRow($select);

         if ($data) 
		 {
            $object->setData($data);
         }
		 
        $this->_afterLoad($object);

        return $this;		 			
	}
	
    /**
     * Sets the field condition_enabled to NULL
     * 
     * This function is executed, the new eBay Category Features were imported
     *
     * @return void
     */		
	public function setAllConditionsToNull()
	{	
	    try {
            $this->_getWriteAdapter()->update(
                $this->getMainTable(),array('condition_enabled'=>NULL)   
            );
            
            $this->_getWriteAdapter()->commit();
        } 
        catch (Exception $e) {
            $this->_getWriteAdapter()->rollBack();
        }		
	}

    /**
     * Deletes all imported eBay Categories
     * 
     * @return void
     */		
    public function deleteAllEbayCategories()
    {
    	$write = $this->_getWriteAdapter();     
            
        $write->delete($this->getMainTable(),
                $write->quoteInto($this->getMainTable().'.store=?', 0)
        );  
    }	
    
    /**
     * Deletes all eBay Store Categories
     * 
     * @return void
     */		
    public function deleteAllEbayStoreCategories()
    {
    	$write = $this->_getWriteAdapter();     
            
        $write->delete($this->getMainTable(),
                $write->quoteInto($this->getMainTable().'.store=?', 1)
        );  
    }	
}
?>
