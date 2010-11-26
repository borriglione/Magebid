<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'CalculatedShippingChargeOptionCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'InsuranceOptionCodeType.php';
require_once 'CalculatedShippingRateOptionCodeType.php';
require_once 'AmountType.php';

/**
 * Calculated shipping preferences for the user. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/CalculatedShippingPreferencesType.html
 *
 */
class CalculatedShippingPreferencesType extends EbatNs_ComplexType
{
	/**
	 * @var AmountType
	 */
	protected $CalculatedShippingAmountForEntireOrder;
	/**
	 * @var CalculatedShippingChargeOptionCodeType
	 */
	protected $CalculatedShippingChargeOption;
	/**
	 * @var CalculatedShippingRateOptionCodeType
	 */
	protected $CalculatedShippingRateOption;
	/**
	 * @var InsuranceOptionCodeType
	 */
	protected $InsuranceOption;

	/**
	 * @return AmountType
	 */
	function getCalculatedShippingAmountForEntireOrder()
	{
		return $this->CalculatedShippingAmountForEntireOrder;
	}
	/**
	 * @return void
	 * @param AmountType $value 
	 */
	function setCalculatedShippingAmountForEntireOrder($value)
	{
		$this->CalculatedShippingAmountForEntireOrder = $value;
	}
	/**
	 * @return CalculatedShippingChargeOptionCodeType
	 */
	function getCalculatedShippingChargeOption()
	{
		return $this->CalculatedShippingChargeOption;
	}
	/**
	 * @return void
	 * @param CalculatedShippingChargeOptionCodeType $value 
	 */
	function setCalculatedShippingChargeOption($value)
	{
		$this->CalculatedShippingChargeOption = $value;
	}
	/**
	 * @return CalculatedShippingRateOptionCodeType
	 */
	function getCalculatedShippingRateOption()
	{
		return $this->CalculatedShippingRateOption;
	}
	/**
	 * @return void
	 * @param CalculatedShippingRateOptionCodeType $value 
	 */
	function setCalculatedShippingRateOption($value)
	{
		$this->CalculatedShippingRateOption = $value;
	}
	/**
	 * @return InsuranceOptionCodeType
	 */
	function getInsuranceOption()
	{
		return $this->InsuranceOption;
	}
	/**
	 * @return void
	 * @param InsuranceOptionCodeType $value 
	 */
	function setInsuranceOption($value)
	{
		$this->InsuranceOption = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('CalculatedShippingPreferencesType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'CalculatedShippingAmountForEntireOrder' =>
					array(
						'required' => false,
						'type' => 'AmountType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'CalculatedShippingChargeOption' =>
					array(
						'required' => false,
						'type' => 'CalculatedShippingChargeOptionCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'CalculatedShippingRateOption' =>
					array(
						'required' => false,
						'type' => 'CalculatedShippingRateOptionCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'InsuranceOption' =>
					array(
						'required' => false,
						'type' => 'InsuranceOptionCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
