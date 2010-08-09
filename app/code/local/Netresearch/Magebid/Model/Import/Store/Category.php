<?php
class Netresearch_Magebid_Model_Import_Store_Category extends Mage_Core_Model_Abstract
{
    protected $_count;	
	
	protected function _construct()
    {
        $this->_init('magebid/import_category');
    }	
	
	public function importEbayStoreCategories()
	{		
		//get all categories
		if (!$ebay_store_categories = Mage::getModel('magebid/ebay_store')->geteBayStoreCategories())
		{
			return false;
		}
		
		//If there are some categories
		if (count($ebay_store_categories)>0)
		{
			//delete all existing categories
			$collection = $this->getCollection();
			$collection->addFieldToFilter('store','1');	 
			foreach ($collection as $colItem){
			       $colItem->delete();
			} 		
		}
		
		//Add the new categories
		foreach ($ebay_store_categories as $category)
		{
			//Build the data
			$data = array(
				'category_id' => $category->CategoryID,
				'category_level' => 1,	
				'category_name' => Mage::helper('coding')->encodePrepareDb($category->Name),
				'category_parent_id' => $category->CategoryID,		
				'store'	=> 1
				);				
			
			//save
			$this->setData($data)->save();
			
			//set Child Categories
			$this->_setChildCats($category,1);
			
			$this->_count++;
		}	

		//exit('ende');

		return $this->_count;
	}
	
	protected function _setChildCats($category,$level)
	{		
		if (is_array($category->ChildCategory))
		{			
			foreach ($category->ChildCategory as $sub_category)
			{			
				//Build the data
				$data = array(
					'category_id' => $sub_category->CategoryID,
					'category_level' => $level+1,	
					'category_name' => Mage::helper('coding')->encodePrepareDb($sub_category->Name),
					'category_parent_id' => $category->CategoryID,		
					'store'	=> 1
					);				
				
				//save
				$this->setData($data)->save();
				
				//set Child Categories
				$this->_setChildCats($sub_category,$level+1);	
				
				$this->_count++;			
			}
		}
	}
}
?>
