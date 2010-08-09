<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Policy extends Mage_Adminhtml_Block_Widget
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Return Policy');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Return Policy");
    }	
	
    public function getCatalogData()
    {
        return array(
            'import_payment_methods'   => array(
                'label'     => Mage::helper('magebid')->__('Import Return Policies'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_return_policies',
                        'action'    => Mage::helper('adminhtml')->__('Import'),
                        )
                ),
            ),
        );
    }
}
?>
