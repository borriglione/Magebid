<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Mapping
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Mapping extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element = null;
    protected $_paymentMethods = null;

    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        $this->setTemplate('magebid/configuration/tab/mapping/payment.phtml');
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
     * Get imported payment methods from ebay
     * 
     * @return array|null
     */	
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
	
    /**
     * Get avaiable payment methods from magento
     * 
     * @return array
     */	
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
                    'onclick'   => 'paymentMethodControl.addItem()',
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