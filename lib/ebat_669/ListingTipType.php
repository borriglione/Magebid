<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'ListingTipMessageType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'ListingTipFieldType.php';

/**
 * A tip on improving a listing's details. Tips are returned from the Listing 
 * Analyzer engine. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ListingTipType.html
 *
 */
class ListingTipType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $ListingTipID;
	/**
	 * @var int
	 */
	protected $Priority;
	/**
	 * @var ListingTipMessageType
	 */
	protected $Message;
	/**
	 * @var ListingTipFieldType
	 */
	protected $Field;

	/**
	 * @return string
	 */
	function getListingTipID()
	{
		return $this->ListingTipID;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setListingTipID($value)
	{
		$this->ListingTipID = $value;
	}
	/**
	 * @return int
	 */
	function getPriority()
	{
		return $this->Priority;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setPriority($value)
	{
		$this->Priority = $value;
	}
	/**
	 * @return ListingTipMessageType
	 */
	function getMessage()
	{
		return $this->Message;
	}
	/**
	 * @return void
	 * @param ListingTipMessageType $value 
	 */
	function setMessage($value)
	{
		$this->Message = $value;
	}
	/**
	 * @return ListingTipFieldType
	 */
	function getField()
	{
		return $this->Field;
	}
	/**
	 * @return void
	 * @param ListingTipFieldType $value 
	 */
	function setField($value)
	{
		$this->Field = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ListingTipType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'ListingTipID' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Priority' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Message' =>
					array(
						'required' => false,
						'type' => 'ListingTipMessageType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Field' =>
					array(
						'required' => false,
						'type' => 'ListingTipFieldType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
