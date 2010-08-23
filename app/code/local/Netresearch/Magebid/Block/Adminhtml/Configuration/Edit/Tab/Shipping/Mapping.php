<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping_Mapping
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping_Mapping extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element = null;
    protected $_shippingMethods = null;

    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        $this->setTemplate('magebid/configuration/tab/mapping/shipping.phtml');
    }
	
    /**
     * Return rendered HTML
     *
     * @return string
     */	
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }
	
    /**
     * Set Element
     * 
     * @param object $element Varien_Data_Form_Element_Abstract
     * 
     * @return object
     */	
    public function setElement(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this;
    }

    /**
     * Get Element
     * 
     * @return object
     */	
    public function getElement()
    {
        return $this->_element;
    }
    
    /**
     * Get imported shipping methods from ebay
     * 
     * @param string $shippingCode
     * 
     * @return array
     */	
	public function geteBayShippingMethods($shippingCode=null)
	{
        if (!$this->_shippingMethods) {
            $collection = Mage::getModel('magebid/import_shipping')->getCollection()
            	->setOrder('shipping_service', 'asc') 
                ->load();

            foreach ($collection->getIterator() as $item) {
                $this->_shippingMethods[$item->getShippingService()] = $item->getDescription();
            }			
        }
        return is_null($shippingCode) ? $this->_shippingMethods :
            (isset($this->_shippingMethods[$shippingCode]) ? $this->_shippingMethods[$shippingCode] : null);		
	}
	
    /**
     * Get avaiable shipping methods from magento
     * 
     * @param string $shippingCode
     * 
     * @return array
     */	
	public function getMagentoShippingMethods($shippingCode=null)
	{
		$carriers = new Mage_Shipping_Model_Config();		
		$carriers = $carriers->getAllCarriers();
		
		$magento_shipping_methods = array();
		
		foreach ($carriers as $carrier)
		{
			 $className = Mage::getStoreConfig('carriers/'.$carrier->getId().'/model');
			 if ($className)
			 {
		         $obj = Mage::getModel($className);
		         //$obj->setStore(2);			//FoTix	
	
				 foreach ($obj->getAllowedMethods() as $key=>$method)
				 {
				 	$magento_shipping_methods[$carrier->getId()."_".$key] = $method." (".$carrier->getId().")";
				 }			 	
			 }
		}		
		return $magento_shipping_methods;
		
	}	
	
    /**
     * Prepare Layout
     * 
     * @return object
     */	
    protected function _prepareLayout()
    {
        $this->setChild('add_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('magebid')->__('Add mapping'),
                    'onclick'   => 'shippingMethodControl.addItem()',
                    'class' => 'add'
                )));
        return parent::_prepareLayout();
    }

    /**
     * Return Add-Button-Html
     * 
     * @return string
     */	
    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }		
	
    /**
     * Get existing mapping
     * 
     * @return array
     */	
    public function getValues()
    {
        $values = array();
    	$data = Mage::getModel('magebid/mapping')->getCollection()->addFilter('kind','shipping')->getItems();

		if (count($data>0))
		{
			foreach ($data as $value)
			{
				$values[] = $value;
			}					
		}
        return $values;
    } 
	
    /**
     * Return true if it's allowed to edit the mapping
     * 
     * @return boolean
     */	
	public function getAllowEdit()
	{
		$role = Mage::registry('role');
		if ($role=='view') return false;
		return true;
	}	
}
?>