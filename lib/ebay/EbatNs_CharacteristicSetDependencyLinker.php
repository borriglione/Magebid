<?php 
require_once 'GetAttributesCSRequestType.php';
require_once 'GetAttributesCSResponseType.php';

class EbatNs_CharacteristicSetDependencyLinker
{
	private $_CharactericsSet = array();
	private $_AttributeSystemVersion;
	
	private $_proxy;
	
	private $_csIdent;
	private $_attribIdent;
	private $_valueIdent;
	
	public function __construct($proxy)
	{
		$this->_proxy = $proxy;
	}
	
	public function getCharactericsSetArray()
	{
		return $this->_CharactericsSet;
	}
	
	public function getCharactericsSet($index)
	{
		return $this->_CharactericsSet[$index];
	}
	
	public function getAttVersion()
	{
		return $this->_AttributeSystemVersion;
	}

	public function getCharactericsSetCount()
	{
		return count($this->_CharactericsSet);
	}
	
	// $csSetId could be either a single csSet-id or an array of ids
	public function fetchByCsSetId($csSetId, $VersionOnly = false)
	{
		if (is_array($csSetId))
		{
			foreach($csSetId as $setId)
				$this->_fetchCsSets($setId, $VersionOnly);					
		}
		else
			$this->_fetchCsSets($csSetId, $VersionOnly);
	}
	
	// use $VersionOnly to populate only the version fields
	public function fetchAll($VersionOnly = false)
	{
		$this->_fetchCsSets(null, $VersionOnly);
	}
	
	// function to link the dependent attributes into their parent attribute values
	private function linkDependencies($attribList, $dependencies)
	{
		// get each parent attributeid and the dependencies for each value
		foreach($dependencies as $parentId => $parentValueArray)
		{
			// reference to the parent attribute object
			$parentAttribObj = &$attribList[$parentId];
			// get each value of the parent attribute and the array of childs
			foreach($parentValueArray as $parentValue => $childIdArray)
				// get each attributeid of the childs and their arrays of values
				foreach($childIdArray as $childId => $childValueArrays)
					// sometimes we have multiple arrays of values with the same child attributeid
					//   linking to valueid of the parent's attribute
					foreach($childValueArrays as $outerKey => $childValueArray)
					{
						// pick a copy of the attribute for the child attributeid
						if (is_object($attribList[$childId]))
							// we have to use the clone keyword with brackets,
							// as PHP4 doesn't know this keyword. a function clone()
							// has to be defined in global scope. PHP5 ignores the
							// brackets and executes the internal "clone"
							$childAttribObj = clone($attribList[$childId]);
						else
							$childAttribObj = $attribList[$childId];
						// empty the values of the child attribute, since we don't need all
						//   valueobjects of in the child attribute for the specific parent attribute
						$childAttribObj->getValueList()->setValue(array());
						// get the dependency type for a later rendering of the csset
						$dependencyType = $childValueArray[0];
						// get each valueobject to be linked to the parent attributes value
						foreach($childValueArray[1] as $key => $childValueObj)
						{
							// get the valueid of the childs valueonject
							$childValue = $childValueObj->getTypeAttribute('id');
							// pick the childs attribute value and reference it to the 
							//   parents value array
							$childAttribObj->getValueList()->setValue($attribList[$childId]->getValueList()->getValue($this->_valueIdent[$childId][$childValue]), $key);
							// unset the dependency object of the child attribute,
							//   as we don't need it anymore
							$childAttribObj->setDependency(null);
						}
						// update the count value for the inserted child attribute values
						$childAttribObj->getValueList()->attributeValues['count'] = count($childAttribObj->getValueList()->getValue());
						// insert the dependency type to the child attribute object for a later rendering
						$childAttribObj->attributeValues['dependencyType'] = $dependencyType;
						// copy the child attribute object to the parent's attribute value object
						$parentAttribObj->getValueList()->getValue($this->_valueIdent[$parentId][$parentValue])->setDependencyList($childAttribObj, $outerKey);
						// unset the dependency object of the parent attribute,
						//   as we don't need it anymore
						$parentAttribObj->setDependency(null);
					}
		}
		
		return $attribList;
	}
	
	// combine the working array of the linked attribute with the complete attributeData-section
	//   of the GetAttributesCS-call
	private function combineCharacteristics($attributeData, $linkedAttribs)
	{
		// get each linked attribute object and the cssetid it belongs to
		foreach($linkedAttribs as $linkedCharacteristicSetId => $linkedAttributeArray)
		{
			// reference to the attribute array of the csset in the attributeData-section
			//   of the GetAttributesCS-call
			$characteristicsListInitial = &$attributeData->getCharacteristics(0)->getCharacteristicsSet($this->_csIdent[$linkedCharacteristicSetId])->getCharacteristicsList()->getInitial();
			// empty the attribute array, since we have rebuilt all attributes in the working array
			$characteristicsListInitial = array();
			// get each linked attribute to copy it to the reference of the attributeData
			foreach($linkedAttributeArray as $linkedAttribute)
				// don't copy attributes which are a child (have a parent attribute id),
				//   since we have linked/inserted them to the parent attributes
				if (!isset($linkedAttribute->attributeValues['parentAttrId']))
					$characteristicsListInitial[] = $linkedAttribute;
		}

		return $attributeData;
	}
	
	// - build some arrays for an easy location of the sets, attributes and value
	//     deep inside the characteristic sets
	// - copy all attributes and their dependencies to link them together
	private function manageDependencies($attributeData)
	{
		// array to identify and locate the cssets
		$this->_csIdent = array();

		// pick up all cssets to link the dependent attributes of each set			
		$characteristics = $attributeData->getCharacteristics();
		$CharacteristicsSets = $characteristics[0]->getCharacteristicsSet();
		foreach($CharacteristicsSets as $CharacteristicsSetKey => $CharacteristicsSet)
		{
			// working array of all attributes in a set
			$copyAttribs = array();
			// working array of all dependencies between all attributes in a set
			$depArray = array();
			// array to identify and locate the attributes
			$this->_attribIdent = array();
			// array to identify and locate the attributevalues
			$this->_valueIdent = array();
			
			// save the array-keyids of each csset for an easy location
			$this->_csIdent[$CharacteristicsSet->attributeValues['id']] = $CharacteristicsSetKey;
			
			// pick up all attributes and dependencies in the set and copy them 
			//   to the working arrays
			$csAttribs = $CharacteristicsSet->getCharacteristicsList()->getInitial();
			foreach($csAttribs as $csAttribKey => $csAttrib)
			{
				// save the array-keyids of each attribute for an easy location
				$this->_attribIdent[$csAttrib->attributeValues['id']] = $csAttribKey;
				// copy each attribute to the working array
				$copyAttribs[$csAttrib->attributeValues['id']] = $csAttrib;

				// pick up all attributevalues and dependencies of the attribute
				if ($csAttrib->getValueList())
				{
					// save the array-keyids of each value of the attribute
					//   for an easy location
					foreach($csAttrib->getValueList()->getValue() as $valueKey => $valueList)
						$this->_valueIdent[$csAttrib->attributeValues['id']][$valueList->attributeValues['id']] = $valueKey;
				}
				
				if ($csAttrib->getDependency())
				{
					// build the working array of all dependencies of the attribute
					foreach($csAttrib->getDependency() as $dependency)
						$depArray[$csAttrib->attributeValues['id']][$dependency->attributeValues['parentValueId']][$dependency->attributeValues['childAttrId']][] = array($dependency->attributeValues['type'], $dependency->getValue());
				}
			}

			// link all dependencies of a single csset to the attributes
			$linkedAttribs[$CharacteristicsSet->attributeValues['id']] = $this->linkDependencies($copyAttribs, $depArray);
		}
	
		// combine the linked working arrays of all cssets with the attributeData-section
		//   of the GetAttributesCS-call
		$combinedCharacteristicSets = $this->combineCharacteristics($attributeData, $linkedAttribs);

		return $combinedCharacteristicSets;
	}

	// $CsIdToGet can be null (and so loading ALL CsSets)
	// use $VersionOnly to populate only the version fields
	private function _fetchCsSets($CsIdToGet, $VersionOnly = false)
	{
		// so query the CharactericsSet ...
		$request = new GetAttributesCSRequestType(); 
		
		if ($CsIdToGet)
			$request->setAttributeSetID($CsIdToGet);

		if (!$VersionOnly)
		{
			$request->setDetailLevel('ReturnAll');
		}

		$response = $this->_proxy->GetAttributesCS($request);
		
		$this->_AttributeSystemVersion = $response->getAttributeSystemVersion();
		
		if (!$VersionOnly)
		{
			$attributeData = $response->getAttributeData();

			$parser = $this->_proxy->getParser('http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd');
			$parser->setExtensionPrefix('EbatNsCsSetExt_');
									
			$parserResponse = $parser->decode('eBay', '<?xml version="1.0" encoding="utf-8" ?>' . utf8_encode($attributeData), 3, 'EbatNsCsSetExt_AttributeDataType');

			$attributeDependencyData = $this->manageDependencies($parserResponse);

			$characteristics = $attributeDependencyData->getCharacteristics();
			$characteristics = $characteristics[0];

			$characteristicSets = $characteristics->getCharacteristicsSet();
			foreach($characteristicSets as $characteristicSet)
			{
				$this->_CharactericsSet[$characteristicSet->attributeValues['id']] = $characteristicSet;
			}
		}
	}
}
?>