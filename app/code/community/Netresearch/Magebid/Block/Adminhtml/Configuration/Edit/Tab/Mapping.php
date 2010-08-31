<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Mapping
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Mapping extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/mapping/index.phtml');
    }		
	
    /**
     * Return Header Text
     *
     * @return string
     */		
	public function getHeaderText()
	{
		return Mage::helper('magebid')->__('Mappings');
	}
	
    /**
     * Return Save Button Params
     *
     * @return array
     */		
	public function getSaveButton()
	{
		$button = array('name'      => 'import_mapping_settings',
                        'action'    => Mage::helper('adminhtml')->__('Save'),
						'clickAction' => 'importAction(this)');
		return $button;
	}
	
    /**
     * Prepare Form
     *
     * @return object
     */		
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();		
		
		$fieldset_shipping = $form->addFieldset('edit_magebid_shipping_mapping', array('legend' => Mage::helper('magebid')->__('Mapping Shipping Services')));
		
        $fieldset_shipping->addField('shipping_method', 'text', array(
                'name'=>'shipping_method',
                'class'=>'requried-entry',
        ));

        $form->getElement('shipping_method')->setRenderer(
            $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_shipping_mapping')
        );   	
				
        //$form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();	
	}
	
	
}
?>