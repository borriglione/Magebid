<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Category extends Mage_Adminhtml_Block_Widget
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Categories');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Categories");
    }	
	
    public function getCatalogData()
    {
        return array(
            'import_categories'   => array(
                'label'     => Mage::helper('adminhtml')->__('Import Categories'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_categories',
                        'action'    => Mage::helper('adminhtml')->__('Import'),
                        )
                ),
            ),
        );
    }
	
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_category_grid', 'configuration.category.grid'));
        return parent::_beforeToHtml();
    }			
}
?>
