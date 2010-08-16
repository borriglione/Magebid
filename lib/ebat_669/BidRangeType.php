<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Contains fields for limiting a call response to items witha minimum or maximum 
 * numberof bids. You also can specify a bid range by specifyingboth a minimum and 
 * maximum number of bids in one call. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/BidRangeType.html
 *
 */
class BidRangeType extends EbatNs_ComplexType
{
	/**
	 * @var int
	 */
	protected $MinimumBidCount;
	/**
	 * @var int
	 */
	protected $MaximumBidCount;

	/**
	 * @return int
	 */
	function getMinimumBidCount()
	{
		return $this->MinimumBidCount;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setMinimumBidCount($value)
	{
		$this->MinimumBidCount = $value;
	}
	/**
	 * @return int
	 */
	function getMaximumBidCount()
	{
		return $this->MaximumBidCount;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setMaximumBidCount($value)
	{
		$this->MaximumBidCount = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('BidRangeType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'MinimumBidCount' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'MaximumBidCount' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
