<?php
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Shipping_Abstract extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{

    protected $_element = null;
    protected $_shippingMethods = null;
    protected $_websites = null;

    public function __construct()
    {
        $this->setTemplate('magebid/tab/shipping/method.phtml');
    }	
	
    public function getProduct()
    {
        return Mage::registry('product');
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
	
	public function getShippingMethods($shippingCode=null)
	{
        if (!$this->_shippingMethods) {
            $collection = Mage::getModel('magebid/import_shipping')
            	->getCollection()
            	->setOrder('description', 'asc')  
                ->load();

            foreach ($collection->getIterator() as $item) {
                $this->_shippingMethods[$item->getShippingService()] = $item->getDescription();
            }
        }
        return is_null($shippingCode) ? $this->_shippingMethods :
            (isset($this->_shippingMethods[$shippingCode]) ? $this->_shippingMethods[$shippingCode] : null);		
	}
	
    protected function _prepareLayout()
    {
        $this->setChild('add_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('magebid')->__('Add Shipping Method'),
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
        $values =array();
        
        if (Mage::registry('frozen_magebid'))
        {
            $data = Mage::registry('frozen_magebid')->getData();
			if (isset($data['shipping_methods']) && count($data['shipping_methods']>0))
			{
				foreach ($data['shipping_methods'] as $value)
				{
					$values[] = $value;
				}					
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