<?php
/**
 * Mbid_Magebid_Model_Import_Category
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Import_Category extends Mage_Core_Model_Abstract
{
    /**
     * 0-origin ebay categories / 1-ebay store categories
     * @var int
     */		
    protected $_ebay_store_flag = 0;	
    
    /**
     * Category_id of the dataset
     * @var int
     */		
    protected $_dataset_stored_category_id = 0;	
	
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
     * Set Ebay Store Flag
     *
     * @return object This
     */	
	public function setEbayStoreFlag()
	{
		$this->_ebay_store_flag = 1;
		return $this;
	}	
	
    /**
     * Main Function to import categories
     *
     * @return boolean|int If import fails return false, else return the number of imported categories
     */		
	public function importEbayCategories()
	{
		//get all categories
		if (!$ebay_categories = Mage::getModel('magebid/ebay_miscellaneous')->geteBayCategories())
		{
			return false;
		}
	
		//Delete all existing ebay categories
		$this->getResource()->deleteAllEbayCategories();	
		
		//Add the new categories
		foreach ($ebay_categories->CategoryArray as $category)
		{
			//Build the data
			$data = array(
				'category_id' => $category->CategoryID,
				'category_level' => $category->CategoryLevel,	
				'category_name' => $category->CategoryName,
				'category_parent_id' => $category->CategoryParentID[0],		
				);				
			
			//save
			$this->setData($data)->save();
		}			
		
		//Delete entry for the last category features version->Otherwise the category features were not updated
		Mage::getModel('magebid/configuration')->load('category_features_version','key')->delete();
		
		return count($ebay_categories->CategoryArray);
	}	
	
    /**
     * Build Category Tree
     * 
     * If $selected_cat isn't set, building CategoryTree from the root
     * else build CategoryTree recursive
     * 
     * @param int $selected_cat Category_id
     *
     * @return array 
     */		
	public function buildTree($selected_cat = 0)
	{
		//Save the origin dataset category_id
		$this->_dataset_stored_category_id = $selected_cat;
	
		if ($selected_cat=='' || $selected_cat==0 || $selected_cat==1) //1 = root-category (in case of empty trees)
		{
			$cat_array = array(
						'text'=>'eBay',
						'id'=>'1',
						'path'=>'1',
						'cls'=>'folder active-category',
						'children' => $this->_addChildren(null)
						);			
		}
		else
		{
			$cat_array = $this->_buildRecursiveTree($selected_cat);
		}	
		
		return $cat_array;		
	}	
	
    /**
     * Build Child Category Tree
     * 
     * Get an array of all child-categories for the $category_id
     * 
     * @param int $category_id Category_id
     *
     * @return array 
     */	
	public function buildChildTree($category_id)
	{
		return $this->_addChildren($category_id);						
	}
	
    /**
     * Add children categories
     * 
	 * Get all children to a given $parent_cat_id
     * 
     * @param int $parent_cat_id Category_id
     * @param int $checked_cat Category_id 
     *
     * @return array
     */		
	protected function _addChildren($parent_cat_id,$checked_cat = 0)
	{
		$collection = $this->getCollection();
		
		if (is_null($parent_cat_id))
		{
			//Level one categories
			$collection->addFieldToFilter('category_level',1);
		}
		else
		{
			//normal categorys
			$collection->addFieldToFilter('category_parent_id',$parent_cat_id); 
		}		
		
		//Check if it is a eBay Store Tree
		if ($this->_ebay_store_flag==1)
		{
			$collection->addFieldToFilter('store',1);			
		}
		else
		{
			$collection->addFieldToFilter('store',0);
		}
		
		$children = array();
		$lauf = 0;
		foreach ($collection as $colItem)
		{			       
				  if ($colItem->getCategoryId()!=$colItem->getCategoryParentId() || is_null($parent_cat_id))
				  {
					   $checked = 0;
					   if ($checked_cat==$colItem->getCategoryId()) $checked = 1;
					   $children[$lauf] = array(
									'text'=>$colItem->getCategoryName(),
									'id'=>$colItem->getCategoryId(),
									'path'=>$this->_buildPath($colItem),
									'cls'=>'folder active-category',
									'allowDrop' => true,
									'allowDrag' => true,
									);	
									
						if ($checked==1) $children[$lauf]['checked'] = true;
						if ($checked==1) $children[$lauf]['expanded'] = true;	
						if ($this->_checkChildren($colItem->getCategoryId())) $children[$lauf]['children'] = array();								
									
						$lauf++;				  	
				  }		
		}	
		
		if (count($children)>0) return $children; else return '';
	}
	
    /**
     * Check if child-categories to a given $parent_cat_id are existing
     * 
     * @param int $parent_cat_id Category_id
     *
     * @return boolean
     */	
	protected function _checkChildren($parent_cat_id)
	{
		$collection = $this->getCollection();
		$collection->addFieldToFilter('category_parent_id',$parent_cat_id); 

		//Check if it is a eBay Store Tree
		if ($this->_ebay_store_flag==1)
		{
			$collection->addFieldToFilter('store',1);			
		}
		else
		{
			$collection->addFieldToFilter('store',0);	
		}
				
		if ($collection->count()>1) return true; else return false;		
	}
	
    /**
     * Calculating path for the category-tree
     * 
     * @param object $cat Magebid Import Category
     * @param string $path
     *
     * @return string
     */	
	protected function _buildPath($cat,$path = '')
	{
		if ($cat->getCategoryLevel()==1)
		{
			$path = '1/'.$cat->getCategoryId().$path;
		}
		else
		{
			$path = '/'.$cat->getCategoryId().$path;
			$cat = $this->load($cat->getCategoryParentId(),'category_id');
			return $this->_buildPath($cat,$path);
		}
		 
		return $path;
	}
	
    /**
     * Building a resursive Category Tree by a given child category
     * 
     * @param int $selected_cat Magebid Import Category ID
     * @param array $cats Categories which were already constructed by this resursive Method
     *
     * @return array
     */	
	protected function _buildRecursiveTree($selected_cat,$cats = array())
	{
		//Get selected cat node
		if ($this->_ebay_store_flag==0)
		{
			$cat = $this->load($selected_cat,'category_id');
		}
		else
		{
			$cat = $this->loadByStore($selected_cat);
		}		
		
		$parent_id = $cat->getCategoryParentId();
		
		//If level = 1
		if ($cat->getCategoryLevel()==1)
		{
			//Set children
			$children = $cats;
			
			//Set sisters
			$cats = $this->_addChildren(null);
			
			
			$checked = 0;			
			foreach ($cats as $key => $value)
			{
				if ($value['id']==$selected_cat)
				{
					$cats[$key]['children'] = $children;
					$cats[$key]['expanded'] = true;
				}
				
				//For the level1-categories which are checked (mostly ebay store categories)
				if ($value['id']==$this->_dataset_stored_category_id)
				{
					$cats[$key]['checked'] = true;
				}
			}		
			
			//echo "--end".$selected_cat."--";	
			
			return array(
	    		'text' => 'Root (0)',
	    		'id' => 1,
	   			'store' => 0,
	   			'path' => 1,
	   			'cls' => 'folder active-category',
	    		'allowDrop' => true,
	    		'allowDrag' => true,
				'expanded' => true,
	    		'children' => $cats, 
			);
		}	
		elseif (count($cats)==0)
		{
			//Beginning of all
			
			//Get all sister cats
			$sisters = $this->_addChildren($parent_id,$selected_cat);
		
			//Go on building
			return $this->_buildRecursiveTree($parent_id,$sisters);		
		}	
		else
		{
			//in the middle of the work
			
			//Set children
			$children = $cats;	
			
			//Set sisters
			$cats = $this->_addChildren($parent_id);
			
			if (is_array($cats))
			{
				foreach ($cats as $key => $value)
				{
					if ($value['id']==$selected_cat)
					{
						$cats[$key]['children'] = $children;
						$cats[$key]['expanded'] = true;
					}
				}				
			}	
			
			//Go on building
			return $this->_buildRecursiveTree($parent_id,$cats);								
		}
		
		return $cats;
	}
	
    /**
     * Get a ebay store category
     * 
     * @param int $id Magebid Import Category ID
     *
     * @return object
     */	
    public function loadByStore($id)
    {
		$this->_getResource()->loadByStore($this, $id);
        $this->_afterLoad();
        $this->setOrigData();
        return $this;
    }	
}
?>
