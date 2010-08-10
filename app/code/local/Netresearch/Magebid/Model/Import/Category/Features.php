<?php
class Netresearch_Magebid_Model_Import_Category_Features extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('magebid/import_category_features');
    }	

	public function importCategoryFeatures()
	{
		if (!$category_features = Mage::getModel('magebid/ebay_miscellaneous')->getCategoriesFeatures())
		{
			return false;
		}	
		
		//Reset Import Categories Table (set conditions required to 0)
		Mage::getResourceModel('magebid/import_category')->setAllConditionsToNull();		
		
		//Delete all existing conditions
		$this->getResource()->deleteAll();	
				
		//For every category
		foreach ($category_features->Category as $category)
		{
			//save if condition is required/not required
			$this->_saveIfConditionIsUsed($category);
		}			
	
		return true;
	}
	
	protected function _saveIfConditionIsUsed($category)
	{
		$import_category = Mage::getModel('magebid/import_category')->load($category->CategoryID,'category_id');
		if ($import_category->getId())
		{
			if ($category->ConditionEnabled == 'Required' || $category->ConditionEnabled == 'Enabled')
			{
				$import_category->setConditionEnabled(1);
				$import_category->save(); //Save conditions relationships			
			}
			else if ($category->ConditionEnabled=='Disabled')
			{
				$import_category->setConditionEnabled(0);
				$import_category->save();
			}			
		}		
		
		$this->_saveConditions($category);		
	}
	
	protected function _saveConditions($category)
	{
		//If not conditions existing, return
		if (count($category->ConditionValues->Condition)==0) return;
		
		foreach ($category->ConditionValues->Condition as $condition)
		{
			try
			{
				$data = array(				
					'key' => 'Condition',
					'value_id' => $condition->ID,
					'value_display_name' => Mage::helper('coding')->encodePrepareDb($condition->DisplayName),
					'category_id' => $category->CategoryID
				);
				
				Mage::getModel('magebid/import_category_features')->addData($data)->save();	
			}
			catch (Exception $e)
			{
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}			
		}
	}
	
	public function getAvailableConditions($ebay_category_id = 0)
	{
		$avaiable_conditions = array();
	
		//If by default, no category is selected
		if ($ebay_category_id)
		{
			array_unshift($avaiable_conditions, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));
			return $avaiable_conditions;
		}
		 
		
		
	
		
		$avaiable_conditions[] = array('value'=>500,'label'=>"Future New");
		$avaiable_conditions[] = array('value'=>1000,'label'=>"New");
		$avaiable_conditions[] = array('value'=>2000,'label'=>"Used");
		
		
		return $avaiable_conditions;
	}
}
?>
