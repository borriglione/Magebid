<?php
// autogenerated file 05.05.2008 16:30
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'EbatNsCsSetExt_AttributeType.php';

/**
 * (in/out) A set of salient aspects or features that describe an item in a 
 * standardized way. Most commonly used in the Item Specifics section of a listing. 
 * See the Developer's Guide information on working with Item Specifics and 
 * Pre-filled Item Information. See the Developer's Guide for information about 
 * characteristics meta-data and how to determine when attributes are required. 
 *
 *
 */
class EbatNsCsSetExt_AttributeSetType extends EbatNs_ComplexType
{
	/**
	 * @var EbatNsCsSetExt_AttributeType
	 */
	protected $Attribute;
	/**
	 * @var string
	 */
	protected $DomainName;

	/**
	 * @return EbatNsCsSetExt_AttributeType
	 * @param integer $index 
	 */
	function getAttribute($index = null)
	{
		if ($index !== null) {
			return $this->Attribute[$index];
		} else {
			return $this->Attribute;
		}
	}
	/**
	 * @return void
	 * @param EbatNsCsSetExt_AttributeType $value 
	 * @param  $index 
	 */
	function setAttribute($value, $index = null)
	{
		if ($index !== null) {
			$this->Attribute[$index] = $value;
		} else {
			$this->Attribute = $value;
		}
	}
	/**
	 * @return void
	 * @param EbatNsCsSetExt_AttributeType $value 
	 */
	function addAttribute($value)
	{
		$this->Attribute[] = $value;
	}
	/**
	 * @return string
	 */
	function getDomainName()
	{
		return $this->DomainName;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setDomainName($value)
	{
		$this->DomainName = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('EbatNsCsSetExt_AttributeSetType', 'http://www.w3.org/2001/XMLSchema');
		$this->_elements = array_merge($this->_elements,
			array(
				'Attribute' =>
				array(
					'required' => false,
					'type' => 'EbatNsCsSetExt_AttributeType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => true,
					'cardinality' => '0..*'
				),
				'DomainName' =>
				array(
					'required' => true,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '1..1'
				)
			));
	$this->_attributes = array_merge($this->_attributes,
		array(
			'attributeSetID' =>
			array(
				'name' => 'attributeSetID',
				'type' => 'int',
				'use' => 'required'
			),
			'attributeSetVersion' =>
			array(
				'name' => 'attributeSetVersion',
				'type' => 'string',
				'use' => 'required'
			),
			'id' =>
			array(
				'name' => 'id',
				'type' => 'int',
				'use' => 'required'
			)
		));

	}
}
?>
