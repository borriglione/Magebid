<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_New
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Export_New extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_mode = 'new';
        $this->_controller = 'adminhtml_export';
		
		$this->_updateButton('save', 'label', Mage::helper('magebid')->__('Continue'));	
		$this->_removeButton('back');
		$this->_removeButton('reset');
    }

    /**
     * Return Header Text
     *
     * @return string
     */	 
    public function getHeaderText()
    {
        return Mage::helper('magebid')->__('New Export');
    }
}
