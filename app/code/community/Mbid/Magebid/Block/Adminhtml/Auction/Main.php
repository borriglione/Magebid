<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Auction_Main
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Auction_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        $this->_addButtonLabel = Mage::helper('magebid')->__('Add New');

        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_controller = 'adminhtml_auction_main';
		$this->setTemplate('magebid/auction/list.phtml');
    }
	
    /**
     * Return Header Text
     *
     * @return string
     */	
    public function getHeaderText()
    {
        return Mage::helper('magebid')->__('Auction List');		
    }
		
    /**
     * Before HTML
     *
     * @return object
     */		
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
	
    /**
     * Get different reasons to end an auction
     *
     * @return array
     */		
	public function getEndItemReasons()
	{
		return Mage::getSingleton('magebid/auction')->getEndItemOptions();		
	}	
}
?>