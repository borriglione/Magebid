<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Mapping extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{

    protected $_element = null;
    protected $_paymentMethods = null;

    public function __construct()
    {
        $this->setTemplate('magebid/configuration/tab/mapping/payment.phtml');
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
	
	public function geteBayPaymentMethods()
	{
        if (!$this->_paymentMethods) {
            $collection = Mage::getModel('magebid/import_payment')->getCollection()
                ->load();

            foreach ($collection->getIterator() as $item) {
                $this->_paymentMethods[$item->getCode()] = $item->getDescription();
            }			
        }
        return (count($this->_paymentMethods)>0) ? $this->_paymentMethods : null;		
	}
	
	public function getMagentoPaymentMethods()
	{		
		$magento_payment_methods = array();
		
		//Get all Payment Methods of the shop
		$methods = Mage::getStoreConfig('payment', null);		
		foreach ($methods as $code => $methodConfig) 
		{
			$prefix = 'payment/'.$code.'/';
            if (!$model = Mage::getStoreConfig($prefix.'model', null)) {
                break;
            }			
			$methodInstance = Mage::getModel($model);		
			
			//Check if it could be used for internal used
			if (!$methodInstance->canUseInternal()) continue;
				
			$magento_payment_methods[$code] = $methodInstance->getTitle();
		}		
		
		return $magento_payment_methods;
	}	
	
    protected function _prepareLayout()
    {
        $this->setChild('add_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('magebid')->__('Add mapping'),
                    'onclick'   => 'paymentMethodControl.addItem()',
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
        $data = Mage::getModel('magebid/mapping')->getCollection()->addFilter('kind','payment')->getItems();

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