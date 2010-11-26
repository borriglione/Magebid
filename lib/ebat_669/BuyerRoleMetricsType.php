<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Specifies 1 year feedback metrics as buyer. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/BuyerRoleMetricsType.html
 *
 */
class BuyerRoleMetricsType extends EbatNs_ComplexType
{
	/**
	 * @var int
	 */
	protected $PositiveFeedbackLeftCount;
	/**
	 * @var int
	 */
	protected $NegativeFeedbackLeftCount;
	/**
	 * @var int
	 */
	protected $NeutralFeedbackLeftCount;
	/**
	 * @var float
	 */
	protected $FeedbackLeftPercent;

	/**
	 * @return int
	 */
	function getPositiveFeedbackLeftCount()
	{
		return $this->PositiveFeedbackLeftCount;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setPositiveFeedbackLeftCount($value)
	{
		$this->PositiveFeedbackLeftCount = $value;
	}
	/**
	 * @return int
	 */
	function getNegativeFeedbackLeftCount()
	{
		return $this->NegativeFeedbackLeftCount;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setNegativeFeedbackLeftCount($value)
	{
		$this->NegativeFeedbackLeftCount = $value;
	}
	/**
	 * @return int
	 */
	function getNeutralFeedbackLeftCount()
	{
		return $this->NeutralFeedbackLeftCount;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setNeutralFeedbackLeftCount($value)
	{
		$this->NeutralFeedbackLeftCount = $value;
	}
	/**
	 * @return float
	 */
	function getFeedbackLeftPercent()
	{
		return $this->FeedbackLeftPercent;
	}
	/**
	 * @return void
	 * @param float $value 
	 */
	function setFeedbackLeftPercent($value)
	{
		$this->FeedbackLeftPercent = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('BuyerRoleMetricsType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'PositiveFeedbackLeftCount' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'NegativeFeedbackLeftCount' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'NeutralFeedbackLeftCount' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'FeedbackLeftPercent' =>
					array(
						'required' => false,
						'type' => 'float',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
