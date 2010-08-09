<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping_Mapping extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{

    protected $_element = null;
    protected $_shippingMethods = null;

    public function __construct()
    {
        $this->setTemplate('magebid/configuration/tab/mapping/shipping.phtml');
    }
	
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }
	
	
    public function setElement(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this;
    }

    public function getElement()
    {
        return $this->_element;
    }
	
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

    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }	
	
	
	
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
	
	public function getAllowEdit()
	{
		$role = Mage::registry('role');
		if ($role=='view') return false;
		return true;
	}	
}
?>