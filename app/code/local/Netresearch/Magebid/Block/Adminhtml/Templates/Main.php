<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Templates_Main
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Templates_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller = 'adminhtml_templates_main';
      	$this->_headerText = Mage::helper('magebid')->__('Magebid Templates');
    }
}
?>