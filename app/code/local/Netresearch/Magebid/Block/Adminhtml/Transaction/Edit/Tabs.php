<?php
class Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();		
        $this->setId('magebid_transaction_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magebid')->__('Transaction'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('transaction', array(
            'label'     => Mage::helper('magebid')->__('General Informations'),
            'title'     => Mage::helper('magebid')->__('General Informations'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_transaction_edit_tab_transaction')->toHtml(),
            'active'    => true,
        ));

		
        $this->addTab('buyer', array(
            'label'     => Mage::helper('magebid')->__('Buyer Informations'),
            'title'     => Mage::helper('magebid')->__('Buyer Informations'),
  			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_transaction_edit_tab_buyer')->toHtml(),
        ));

        $this->addTab('shipping_adress', array(
            'label'     => Mage::helper('magebid')->__('Shipping Adress'),
            'title'     => Mage::helper('magebid')->__('Shipping Adress'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_transaction_edit_tab_shipping_adress')->toHtml(),
        ));		

        $this->addTab('shipping', array(
            'label'     => Mage::helper('magebid')->__('Shipping Methods'),
            'title'     => Mage::helper('magebid')->__('Shipping Methods'),
   			'content'   => $this->getLayout()->createBlock('magebid/adminhtml_transaction_edit_tab_shipping')->toHtml(),
        ));
		

		
        $this->addTab('payment', array(
            'label'     => Mage::helper('magebid')->__('Payment Methods'),
            'title'     => Mage::helper('magebid')->__('Payment Methods'),
    		'content'   => $this->getLayout()->createBlock('magebid/adminhtml_transaction_edit_tab_payment')->toHtml(),
        ));						

        return parent::_beforeToHtml();
    }
}