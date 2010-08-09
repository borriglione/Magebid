<?php
class Netresearch_Magebid_Model_Templates extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('magebid/templates');
	
    }


    protected function _beforeSave()
    {
        $this->setDateModified();  
		
		//if template is new
		$template_id = $this->getId();
		if (is_null($template_id)) $this->setDateCreated();     
    }
	
	
	public function setDateModified()
	{
		$this->setData('date_modified', date('Y-m-d H:i:s'));
		return $this;
	}

	public function setDateCreated()
	{
		$this->setData('date_created', date('Y-m-d H:i:s'));
		return $this;
	}
	
	public function getTemplateTypes()
	{
		return array(0 => array('value'=>'header','label'=>Mage::helper('magebid')->__('Header')),1 => array('value'=>'footer','label'=>Mage::helper('magebid')->__('Footer')),2 => array('value'=>'main','label'=>Mage::helper('magebid')->__('Main template')));
	}

	function getAllTemplatesOptions($template_type = "")
	{
		$collection = parent::getCollection();	
		if ($template_type!='') $collection->addFieldToFilter('content_type',$template_type);	 
		$collection = $collection->toOptionArray();
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));
		return $collection;
	}		
}
?>
