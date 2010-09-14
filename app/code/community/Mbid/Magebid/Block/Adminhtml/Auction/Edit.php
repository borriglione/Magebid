<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Auction_Edit
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Auction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_controller = 'adminhtml_auction';

        if( $this->getRequest()->getParam($this->_objectId) )
		{
            //exit($this->getRequest()->getParam($this->_objectId));
			$magebidData = Mage::getModel('magebid/auction')->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('frozen_magebid', $magebidData);
        }

		//Set Role
		if ($magebidData->getMagebidEbayStatusId()>0)
		{
			$this->_removeButton('save');
			$this->_removeButton('reset');
			Mage::register('role','view');
		}
		else
		{
			Mage::register('role','edit');
	        $this->_addButton('saveandcontinue', array(
	            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
	            'onclick'   => 'saveAndContinueEdit()',
	            'class'     => 'save',
	        ), -100);	
			
	        $this->_formScripts[] = "
	            function saveAndContinueEdit(){
	                editForm.submit($('edit_form').action+'back/edit/');
	            }
	        ";					
		}
    }

    /**
     * Return Header Text
     *
     * @return string
     */	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Auction '%s'",
               $this->htmlEscape(Mage::registry('frozen_magebid')->getAuctionName()));
    }
}