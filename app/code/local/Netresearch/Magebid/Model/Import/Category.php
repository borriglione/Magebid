<?php
/**
 * Netresearch_Magebid_Model_Import_Category
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Import_Category extends Mage_Core_Model_Abstract
{
    /**
     * 0-origin ebay categories / 1-ebay store categories
     * @var int
     */		
    protected $_ebay_store_flag = 0;	
	
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
	
		//If there are some categories, delete them
		$this->getResource()->deleteAll();	
		
		//Add the new categories
		foreach ($ebay_categories->CategoryArray as $category)
		{
			//Build the data
			$data = array(
				'category_id' => $category->CategoryID,
				'category_level' => $category->CategoryLevel,	
				'category_name' => Mage::helper('coding')->encodeStringEbayToMagento($category->CategoryName),
				'category_parent_id' => $category->CategoryParentID[0],		
				);				
			
			//save
			$this->setData($data)->save();
		}			
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
		$cat_array = array();
		
		if ($selected_cat=='' || $selected_cat==0)
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
			//Level one categorys
			$collection->addFieldToFilter('category_level',1);
		}
		else
		{
			//normal categorys
			$collection->addFieldToFilter('category_parent_id',$parent_cat_id); 
		}		
		
		//Check if it is a eBay Store Tree
		if ($this->_ebay_store_flag==1) $collection->addFieldToFilter('store',1);			
		
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
		if ($this->_ebay_store_flag==1) $collection->addFieldToFilter('store',1);			
				
		if ($collection->count()>0) return true; else return false;		
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
			foreach ($cats as $key => $value)
			{
				if ($value['id']==$selected_cat)
				{
					$cats[$key]['children'] = $children;
					$cats[$key]['expanded'] = true;
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
