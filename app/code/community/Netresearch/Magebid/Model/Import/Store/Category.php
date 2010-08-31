<?php
/**
 * Netresearch_Magebid_Model_Import_Store_Category
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Import_Store_Category extends Mage_Core_Model_Abstract
{
    /**
     * Count of all imported eBay Store Categories
     * @var int
     */		
    protected $_count;	
	
    /**
     * Construct
     *
     * @return void
     */	  
	protected function _construct()
    {
        $this->_init('magebid/import_category');
    }	
	
    /**
     * Main Function to import ebay store categories
     *
     * @return boolean|int If import fails return false, else return the number of imported categories
     */		   
	public function importEbayStoreCategories()
	{		
		//get all categories
		if (!$ebay_store_categories = Mage::getModel('magebid/ebay_store')->geteBayStoreCategories())
		{
			return false;
		}
		
		//Delete all existing ebay categories
		$this->getResource()->deleteAllEbayStoreCategories();	
		
		//Add the new categories
		foreach ($ebay_store_categories as $category)
		{
			//Build the data
			$data = array(
				'category_id' => $category->CategoryID,
				'category_level' => 1,	
				'category_name' => Mage::helper('coding')->encodeStringEbayToMagento($category->Name),
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
	
    /**
     * set Child eBay Store Categories (Recursive)
     *
     * @return void
     */		
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
					'category_name' => Mage::helper('coding')->encodeStringEbayToMagento($sub_category->Name),
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
