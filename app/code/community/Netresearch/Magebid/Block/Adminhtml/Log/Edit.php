<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Log_Edit
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Log_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml_log';

        if( $this->getRequest()->getParam($this->_objectId) ) {
            $magebidData = Mage::getModel('magebid/log')
                ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('frozen_magebid', $magebidData);
        }
        
		$this->_removeButton('reset'); 
		$this->_removeButton('save');        
    }
    
    /**
     * Return Header Text
     *
     * @return string
     */	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Edit Element '%s'",
               $this->htmlEscape(Mage::registry('frozen_magebid')->getTitle()));
    }
}
