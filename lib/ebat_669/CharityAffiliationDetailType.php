<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'CharityAffiliationTypeCodeType.php';
require_once 'EbatNs_ComplexType.php';

/**
 * The information of nonprofit charity organization affiliation. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/CharityAffiliationDetailType.html
 *
 */
class CharityAffiliationDetailType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $CharityID;
	/**
	 * @var CharityAffiliationTypeCodeType
	 */
	protected $AffiliationType;
	/**
	 * @var dateTime
	 */
	protected $LastUsedTime;

	/**
	 * @return string
	 */
	function getCharityID()
	{
		return $this->CharityID;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setCharityID($value)
	{
		$this->CharityID = $value;
	}
	/**
	 * @return CharityAffiliationTypeCodeType
	 */
	function getAffiliationType()
	{
		return $this->AffiliationType;
	}
	/**
	 * @return void
	 * @param CharityAffiliationTypeCodeType $value 
	 */
	function setAffiliationType($value)
	{
		$this->AffiliationType = $value;
	}
	/**
	 * @return dateTime
	 */
	function getLastUsedTime()
	{
		return $this->LastUsedTime;
	}
	/**
	 * @return void
	 * @param dateTime $value 
	 */
	function setLastUsedTime($value)
	{
		$this->LastUsedTime = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('CharityAffiliationDetailType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'CharityID' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'AffiliationType' =>
					array(
						'required' => false,
						'type' => 'CharityAffiliationTypeCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'LastUsedTime' =>
					array(
						'required' => false,
						'type' => 'dateTime',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
