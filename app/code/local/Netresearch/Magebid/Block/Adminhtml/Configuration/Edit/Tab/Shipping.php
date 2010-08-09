<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping extends Mage_Adminhtml_Block_Widget
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Shipping');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Shipping Methods");
    }	
	
    public function getCatalogData()
    {
        return array(
            'import_shipping_methods'   => array(
                'label'     => Mage::helper('magebid')->__('Import Shipping Methods'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_shipping_methods',
                        'action'    => Mage::helper('magebid')->__('Import'),
                        )
                ),
            ),
        );
    }
	
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_shipping_grid', 'configuration.shipping.grid'));
        return parent::_beforeToHtml();
    }			
}
?>
