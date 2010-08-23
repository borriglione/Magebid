<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Policy
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Policy extends Mage_Adminhtml_Block_Widget
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
        $this->setTitle('Return Policy');
    }
	
    /**
     * Return Header Text
     *
     * @return string
     */		
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Return Policy");
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
                'label'     => Mage::helper('magebid')->__('Import Return Policies'),
                'buttons'   => array(
                    array(
                        'name'      => 'import_return_policies',
                        'action'    => Mage::helper('adminhtml')->__('Import'),
                        )
                ),
            ),
        );
    }
}
?>
