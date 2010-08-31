<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment extends Mage_Adminhtml_Block_Widget
{	
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/template.phtml');
        $this->setTitle('Payment');
    }
	
    /**
     * Return Header Text
     *
     * @return string
     */		
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Payment Methods");
    }	
	
    /**
     * Return Form Data
     *
     * @return array
     */		
    public function getCatalogData()
    {
        return array(
            'import_payment_methods'   => array(
                'label'     => Mage::helper('adminhtml')->__('Import Payment Methods'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_payment_methods',
                        'action'    => Mage::helper('magebid')->__('Import'),
                        )
                ),
            ),
        );
    }
	
    /**
     * Before HTML
     *
     * @return object
     */		
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_payment_grid', 'configuration.payment.grid'));
        return parent::_beforeToHtml();
    }			
}
?>
