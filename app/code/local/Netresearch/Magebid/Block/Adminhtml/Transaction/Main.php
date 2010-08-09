<?php
class Netresearch_Magebid_Block_Adminhtml_Transaction_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_controller = 'adminhtml_transaction_main';
	       
        $this->_addButton('update_all_button',array(
                    'label'     => Mage::helper('magebid')->__('Update all transactions'),
                    'onclick'   => 'setLocation(\''.$this->getUrl('*/*/updateAll').'\')'
                )
        );		
    }
	
    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Transaction list');		
    }
		
    public function _beforeToHtml()
    {	
		$this->_removeButton('add');		
        return parent::_beforeToHtml();
    }	
}
?>