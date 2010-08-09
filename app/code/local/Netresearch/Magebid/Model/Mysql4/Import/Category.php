<?php
class Netresearch_Magebid_Model_Mysql4_Import_Category extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/import_category', 'magebid_import_category_id');
    }	
	
	public function loadByStore($object, $value, $field)
	{
		 $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where($this->getMainTable().'.'.$field.'=?', $value)
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
}
?>
