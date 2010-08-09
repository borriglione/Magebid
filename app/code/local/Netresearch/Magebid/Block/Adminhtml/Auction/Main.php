<?php
class Netresearch_Magebid_Block_Adminhtml_Auction_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_addButtonLabel = Mage::helper('magebid')->__('Add New');

        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_controller = 'adminhtml_auction_main';
		$this->setTemplate('magebid/auction/list.phtml');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')->__('Auction List');		
    }
		
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('adminhtml/admin_auction_main_grid', 'auction.main.grid'));		

        $this->setChild('update_all_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('magebid')->__('Update all auctions'),
                    'onclick'   => 'setLocation(\''.$this->getUrl('*/*/updateall').'\')'
                ))
        );			

        return parent::_beforeToHtml();
    }		
	
	public function getEndItemReasons()
	{
		return Mage::getSingleton('magebid/auction')->getEndItemOptions();		
	}	
}
?>