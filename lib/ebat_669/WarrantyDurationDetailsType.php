<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 *  
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/WarrantyDurationDetailsType.html
 *
 */
class WarrantyDurationDetailsType extends EbatNs_ComplexType
{
	/**
	 * @var token
	 */
	protected $WarrantyDurationOption;
	/**
	 * @var string
	 */
	protected $Description;

	/**
	 * @return token
	 */
	function getWarrantyDurationOption()
	{
		return $this->WarrantyDurationOption;
	}
	/**
	 * @return void
	 * @param token $value 
	 */
	function setWarrantyDurationOption($value)
	{
		$this->WarrantyDurationOption = $value;
	}
	/**
	 * @return string
	 */
	function getDescription()
	{
		return $this->Description;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setDescription($value)
	{
		$this->Description = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('WarrantyDurationDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'WarrantyDurationOption' =>
					array(
						'required' => false,
						'type' => 'token',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Description' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
