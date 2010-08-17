<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_CategoryFeatures extends Mage_Adminhtml_Block_Widget
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Category Features');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Category Features");
    }	
	
    public function getCatalogData()
    {
        return array(
            'import_payment_methods'   => array(
                'label'     => Mage::helper('magebid')->__('Import Category Features'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_category_features',
                        'action'    => Mage::helper('adminhtml')->__('Import'),
                        )
                ),
            ),
        );
    }
}
?>
