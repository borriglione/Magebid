<?php
/**
 * Netresearch_Magebid_Model_System_Config_Source_Sales_Order_Status
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_System_Config_Source_Sales_Order_Status
{
    /**
     * Order Statuses
     * @var array
     */		
    protected $_options;
	
    /**
     * Return the avaiable order statuses
     * 
     * @param boolean $isMultiselect if Multiselect for the order status selection is allowed 
     *
     * @return array
     */	      
	public function toOptionArray($isMultiselect=false)
    {		
		if (!$this->_options) {
            $this->_options = array();
			
			$options = Mage::getSingleton('sales/order_config')->getStatuses();             

			foreach ($options as $key => $option)
			{
				$this->_options[] = array('value'=>$key,'label'=>$option);
			}		
		} 
	   
        if(!$isMultiselect){
            array_unshift($this->_options, array('value'=>'', 'label'=> Mage::helper('adminhtml')->__('--Please Select--')));
        }	
	
		return $this->_options;		
    }
}
?>