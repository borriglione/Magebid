<?php
class EbatNs_OutputSelector
{
	protected $selectorTagNames = array();
	public function __construct($selectorTagName)
	{
		$this->addTagName($selectorTagName);
	}
	
	public function addTagName($selectorTagName)
	{
		if (is_array($selectorTagName))
			$this->selectorTagNames = array_merge($this->selectorTagNames, $selectorTagName);	
		else
			$this->selectorTagNames[] = $selectorTagName;
	}
	
	public function getSelectorTagNames()
	{
		return $this->selectorTagNames;
	}
}

class EbatNs_OutputSelectorModel
{
	protected $outputSelectors;
	protected $name;
	protected $active;
	
	public function __construct($name = null, $active = true)
	{
		$this->name = $name;
		$this->active = $active;
	}
	
	public function addSelector(EbatNs_OutputSelector $selector)
	{
		$this->outputSelectors[] = $selector;
	}
	
	/**
	 * combine all selectors tagnames and return an array for OutputSelector
	 *
	 */
	public function getSelectorArray()
	{
		$selectorArray = array();
		
		foreach($this->outputSelectors as $outputSelector)
		{
			$selectorArray = array_merge($selectorArray, $outputSelector->getSelectorTagNames());
		}
		
		return $selectorArray;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setActive($active)
	{
		$this->active = $active;
	}
	
	public function getActive()
	{
		return $this->active;
	}
}
?>