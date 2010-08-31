<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Profile_Main
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Profile_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller = 'adminhtml_profile_main';
    }
	
    /**
     * Return Header Text
     *
     * @return string
     */	    
    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Profile List');		
    }
		
    /**
     * Before HTML
     *
     * @return string
     */	
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('adminhtml/admin_profile_main_grid', 'auction.main.grid'));		
        return parent::_beforeToHtml();
    }	
}
?>