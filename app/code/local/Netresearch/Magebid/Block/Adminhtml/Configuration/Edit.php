<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/index.phtml');
        $this->setTitle('Configuration');
        
        $this->_blockGroup = 'magebid';		
        $this->_mode = 'edit';       
    }
	
    /**
     * Init Form
     *
     * @return object
     */	
    public function initForm()
    {        
		$this->setChild('form',
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_form')
                ->initForm()
        );
		
        return $this;
    }	
}