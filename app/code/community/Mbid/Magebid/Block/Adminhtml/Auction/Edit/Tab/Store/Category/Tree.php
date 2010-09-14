<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Auction_Edit_Tab_Store_Category_Tree
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Auction_Edit_Tab_Store_Category_Tree extends Mage_Adminhtml_Block_Catalog_Category_Tree
{
    /**
     * Construct
     *
     * @return void
     */	
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/tab/store/category.phtml');
    }

    /**
     * Get existing eBay Store Category for this entry (profile or auction)
     *
     * @return string
     */	
    public function getEbayStoreCategory($field)
    {        
		if (Mage::registry('frozen_magebid'))
		{
			return Mage::registry('frozen_magebid')->getData($field);
		}		
    }

    /**
     * Get Load URL, for the AJAX-Build-Category-Request
     *
     * @return string
     */	
    public function getLoadTreeUrl($expanded=null)
    {
        return $this->getUrl('*/*/storeCategoriesJson', array('_current'=>true));
    }

    /**
     * Get JSON for the child-tree
     *
     * @return string
     */	
	public function getEbayChildTreeJson($ebay_store_category_id)
	{
		$children = Mage::getModel('magebid/import_category')->setEbayStoreFlag()->buildChildTree($ebay_store_category_id);
        $json = Zend_Json::encode($children);
        return $json;		
	}	
	
    /**
     * Get JSON for the initial store category tree
     *
     * @return string
     */	
	public function getEbayTreeJson($field)
	{
		$selected_cat = '';
		
		if (Mage::registry('frozen_magebid'))
		{
			$selected_cat =  Mage::registry('frozen_magebid')->getData($field);
		}			
		
		$rootArray = Mage::getModel('magebid/import_category')->setEbayStoreFlag()->buildTree($selected_cat);
        $json = Zend_Json::encode(isset($rootArray['children']) ? $rootArray['children'] : array());
        return $json;		
	}	

}
?>