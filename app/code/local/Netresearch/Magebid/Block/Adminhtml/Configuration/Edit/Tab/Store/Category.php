<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Store_Category extends Mage_Adminhtml_Block_Widget
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Store Categories');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Store Categories");
    }	
	
    public function getCatalogData()
    {
        return array(
            'import_store_categories'   => array(
                'label'     => Mage::helper('adminhtml')->__('Import Store Categories'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_store_categories',
                        'action'    => Mage::helper('adminhtml')->__('Import'),
                        )
                ),
            ),
        );
    }
	
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_store_category_grid', 'configuration.store.category.grid'));
        return parent::_beforeToHtml();
    }			
}
?>
