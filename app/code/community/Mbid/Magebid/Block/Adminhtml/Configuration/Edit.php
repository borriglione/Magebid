<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Configuration_Edit
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget
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
        $this->setTitle('Import and Mapping');
        
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