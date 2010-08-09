<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment extends Mage_Adminhtml_Block_Widget
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Payment');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Payment Methods");
    }	
	
    public function getCatalogData()
    {
        return array(
            'import_payment_methods'   => array(
                'label'     => Mage::helper('adminhtml')->__('Import Payment Methods'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_payment_methods',
                        'action'    => Mage::helper('magebid')->__('Import'),
                        )
                ),
            ),
        );
    }
	
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_payment_grid', 'configuration.payment.grid'));
        return parent::_beforeToHtml();
    }			
}
?>
