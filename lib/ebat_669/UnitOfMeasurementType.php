<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Provides a mapping between suggested unit of measure strings andother, less 
 * popular strings. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/UnitOfMeasurementType.html
 *
 */
class UnitOfMeasurementType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $AlternateText;
	/**
	 * @var string
	 */
	protected $SuggestedText;

	/**
	 * @return string
	 * @param integer $index 
	 */
	function getAlternateText($index = null)
	{
		if ($index !== null) {
			return $this->AlternateText[$index];
		} else {
			return $this->AlternateText;
		}
	}
	/**
	 * @return void
	 * @param string $value 
	 * @param  $index 
	 */
	function setAlternateText($value, $index = null)
	{
		if ($index !== null) {
			$this->AlternateText[$index] = $value;
		} else {
			$this->AlternateText = $value;
		}
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function addAlternateText($value)
	{
		$this->AlternateText[] = $value;
	}
	/**
	 * @return string
	 */
	function getSuggestedText()
	{
		return $this->SuggestedText;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setSuggestedText($value)
	{
		$this->SuggestedText = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('UnitOfMeasurementType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'AlternateText' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => true,
						'cardinality' => '0..*'
					),
					'SuggestedText' =>
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
