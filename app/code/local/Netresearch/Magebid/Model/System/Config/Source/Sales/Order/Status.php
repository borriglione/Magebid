<?php

class Netresearch_Magebid_Model_System_Config_Source_Sales_Order_Status
{
    protected $_options;
	
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