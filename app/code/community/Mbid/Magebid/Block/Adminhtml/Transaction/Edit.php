<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Transaction_Edit
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Transaction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_controller = 'adminhtml_transaction';

        if( $this->getRequest()->getParam($this->_objectId) )
		{
            $magebidData = Mage::getModel('magebid/transaction')->load($this->getRequest()->getParam($this->_objectId));
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
          ->__("eBay Transaction '%s'",
               $this->htmlEscape(Mage::registry('frozen_magebid')->getEbayItemId()));
    }
}