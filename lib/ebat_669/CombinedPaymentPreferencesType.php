<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'CalculatedShippingPreferencesType.php';
require_once 'CombinedPaymentOptionCodeType.php';
require_once 'FlatShippingPreferencesType.php';
require_once 'CombinedPaymentPeriodCodeType.php';

/**
 * Defines a seller's preferences for allowing buyers to combine more than 
 * onepurchase into one payment. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/CombinedPaymentPreferencesType.html
 *
 */
class CombinedPaymentPreferencesType extends EbatNs_ComplexType
{
	/**
	 * @var CalculatedShippingPreferencesType
	 */
	protected $CalculatedShippingPreferences;
	/**
	 * @var CombinedPaymentOptionCodeType
	 */
	protected $CombinedPaymentOption;
	/**
	 * @var CombinedPaymentPeriodCodeType
	 */
	protected $CombinedPaymentPeriod;
	/**
	 * @var FlatShippingPreferencesType
	 */
	protected $FlatShippingPreferences;

	/**
	 * @return CalculatedShippingPreferencesType
	 */
	function getCalculatedShippingPreferences()
	{
		return $this->CalculatedShippingPreferences;
	}
	/**
	 * @return void
	 * @param CalculatedShippingPreferencesType $value 
	 */
	function setCalculatedShippingPreferences($value)
	{
		$this->CalculatedShippingPreferences = $value;
	}
	/**
	 * @return CombinedPaymentOptionCodeType
	 */
	function getCombinedPaymentOption()
	{
		return $this->CombinedPaymentOption;
	}
	/**
	 * @return void
	 * @param CombinedPaymentOptionCodeType $value 
	 */
	function setCombinedPaymentOption($value)
	{
		$this->CombinedPaymentOption = $value;
	}
	/**
	 * @return CombinedPaymentPeriodCodeType
	 */
	function getCombinedPaymentPeriod()
	{
		return $this->CombinedPaymentPeriod;
	}
	/**
	 * @return void
	 * @param CombinedPaymentPeriodCodeType $value 
	 */
	function setCombinedPaymentPeriod($value)
	{
		$this->CombinedPaymentPeriod = $value;
	}
	/**
	 * @return FlatShippingPreferencesType
	 */
	function getFlatShippingPreferences()
	{
		return $this->FlatShippingPreferences;
	}
	/**
	 * @return void
	 * @param FlatShippingPreferencesType $value 
	 */
	function setFlatShippingPreferences($value)
	{
		$this->FlatShippingPreferences = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('CombinedPaymentPreferencesType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'CalculatedShippingPreferences' =>
					array(
						'required' => false,
						'type' => 'CalculatedShippingPreferencesType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'CombinedPaymentOption' =>
					array(
						'required' => false,
						'type' => 'CombinedPaymentOptionCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'CombinedPaymentPeriod' =>
					array(
						'required' => false,
						'type' => 'CombinedPaymentPeriodCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'FlatShippingPreferences' =>
					array(
						'required' => false,
						'type' => 'FlatShippingPreferencesType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
