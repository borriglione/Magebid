<?php
class Netresearch_Magebid_Model_System_Config_Source_App
{	
	public function toOptionArray()
    {
    	$app_mode_array = array();
		
		$app_mode_array[] = array('value'=>1,'label'=>Mage::helper('magebid')->__('Sandbox'));
		$app_mode_array[] = array('value'=>0,'label'=>Mage::helper('magebid')->__('Production'));
		
		array_unshift($app_mode_array, array('value'=>'', 'label'=> Mage::helper('adminhtml')->__('--Please Select--')));
		
		return $app_mode_array;		
    }
}
?>