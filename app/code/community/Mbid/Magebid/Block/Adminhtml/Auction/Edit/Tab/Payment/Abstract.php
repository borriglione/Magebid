<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Auction_Edit_Tab_Payment_Abstract
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Auction_Edit_Tab_Payment_Abstract extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element = null;
    protected $_paymentMethods = null;
    protected $_websites = null;

    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        $this->setTemplate('magebid/tab/payment/method.phtml');
    }	
	
    /**
     * Return Product
     *
     * @return object
     */	
    public function getProduct()
    {
        return Mage::registry('product');
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
	public function getPaymentMethods($paymentCode=null)
	{
        if (!$this->_paymentMethods) {
            $collection = Mage::getModel('magebid/import_payment')
            	->getCollection()
            	->setOrder('description', 'asc')  
                ->load();

            foreach ($collection->getIterator() as $item) {
                $this->_paymentMethods[$item->getCode()] = $item->getDescription();
            }
        }
        return is_null($paymentCode) ? $this->_paymentMethods :
            (isset($this->_paymentMethods[$paymentCode]) ? $this->_paymentMethods[$paymentCode] : null);		
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
                    'label'     => Mage::helper('magebid')->__('Add Payment Method'),
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
     * Get existing values
     * 
     * @return array
     */	    public function getValues()
    {
        $values =array();
        
        if (Mage::registry('frozen_magebid'))
        {
        	$data = Mage::registry('frozen_magebid')->getData();
        	
	 		if (isset($data['payment_methods']) && count($data['payment_methods']>0))
			{
				foreach ($data['payment_methods'] as $value)
				{
					$values[] = $value;
				}	
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