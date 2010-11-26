<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'UserIDType.php';
require_once 'GranularityLevelCodeType.php';
require_once 'AbstractRequestType.php';

/**
 * Retrieves all items the user is currently bidding on, and the ones they have 
 * wonor purchased. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetBidderListRequestType.html
 *
 */
class GetBidderListRequestType extends AbstractRequestType
{
	/**
	 * @var boolean
	 */
	protected $ActiveItemsOnly;
	/**
	 * @var dateTime
	 */
	protected $EndTimeFrom;
	/**
	 * @var dateTime
	 */
	protected $EndTimeTo;
	/**
	 * @var UserIDType
	 */
	protected $UserID;
	/**
	 * @var GranularityLevelCodeType
	 */
	protected $GranularityLevel;

	/**
	 * @return boolean
	 */
	function getActiveItemsOnly()
	{
		return $this->ActiveItemsOnly;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setActiveItemsOnly($value)
	{
		$this->ActiveItemsOnly = $value;
	}
	/**
	 * @return dateTime
	 */
	function getEndTimeFrom()
	{
		return $this->EndTimeFrom;
	}
	/**
	 * @return void
	 * @param dateTime $value 
	 */
	function setEndTimeFrom($value)
	{
		$this->EndTimeFrom = $value;
	}
	/**
	 * @return dateTime
	 */
	function getEndTimeTo()
	{
		return $this->EndTimeTo;
	}
	/**
	 * @return void
	 * @param dateTime $value 
	 */
	function setEndTimeTo($value)
	{
		$this->EndTimeTo = $value;
	}
	/**
	 * @return UserIDType
	 */
	function getUserID()
	{
		return $this->UserID;
	}
	/**
	 * @return void
	 * @param UserIDType $value 
	 */
	function setUserID($value)
	{
		$this->UserID = $value;
	}
	/**
	 * @return GranularityLevelCodeType
	 */
	function getGranularityLevel()
	{
		return $this->GranularityLevel;
	}
	/**
	 * @return void
	 * @param GranularityLevelCodeType $value 
	 */
	function setGranularityLevel($value)
	{
		$this->GranularityLevel = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetBidderListRequestType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'ActiveItemsOnly' =>
					array(
						'required' => false,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'EndTimeFrom' =>
					array(
						'required' => false,
						'type' => 'dateTime',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'EndTimeTo' =>
					array(
						'required' => false,
						'type' => 'dateTime',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'UserID' =>
					array(
						'required' => false,
						'type' => 'UserIDType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'GranularityLevel' =>
					array(
						'required' => false,
						'type' => 'GranularityLevelCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
