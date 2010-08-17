<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Transaction_Main
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Transaction_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Construct
     *
     * @return void
     */		
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
	
    /**
     * Return Header Text
     *
     * @return string
     */		
    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Transaction list');		
    }
		
    /**
     * Before HTML-Rendering
     *
     * @return string
     */	
    public function _beforeToHtml()
    {	
		$this->_removeButton('add');		
        return parent::_beforeToHtml();
    }	
}
?>