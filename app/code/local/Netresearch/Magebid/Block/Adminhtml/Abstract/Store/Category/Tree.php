<?php
class Netresearch_Magebid_Block_Adminhtml_Abstract_Store_Category_Tree extends Mage_Adminhtml_Block_Catalog_Category_Tree
{
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/tab/store/category.phtml');
    }

    public function getEbayStoreCategory($field)
    {        
		if (Mage::registry('frozen_magebid'))
		{
			return Mage::registry('frozen_magebid')->getData($field);
		}		
    }

    public function getLoadTreeUrl($expanded=null)
    {
        return $this->getUrl('*/*/storeCategoriesJson', array('_current'=>true));
    }

	public function getEbayChildTreeJson($ebay_store_category_id)
	{
		$children = Mage::getModel('magebid/import_category')->setEbayStoreFlag()->buildChildTree($ebay_store_category_id);
        $json = Zend_Json::encode($children);
        return $json;		
	}	
	
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