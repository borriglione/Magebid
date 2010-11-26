<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping extends Mage_Adminhtml_Block_Widget
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
        $this->setTitle('Shipping');
    }
	
    /**
     * Return Header Text
     *
     * @return string
     */		
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Shipping Methods");
    }	
	
    /**
     * Return Form Data
     *
     * @return array
     */	
    public function getCatalogData()
    {
        return array(
            'import_shipping_methods'   => array(
                'label'     => Mage::helper('magebid')->__('Import Shipping Methods'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_shipping_methods',
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
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_shipping_grid', 'configuration.shipping.grid'));
        return parent::_beforeToHtml();
    }			
}
?>
