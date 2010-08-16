<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'SiteLocationType.php';

/**
 * One of the data filters used when searching for items usingGetSearchResults or 
 * GetCategoryListings. Allows filtering based on the location of the item or its 
 * availability relative to an eBay site. Or allows for filtering based on regional 
 * listing. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/SearchLocationType.html
 *
 */
class SearchLocationType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $RegionID;
	/**
	 * @var SiteLocationType
	 */
	protected $SiteLocation;

	/**
	 * @return string
	 */
	function getRegionID()
	{
		return $this->RegionID;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setRegionID($value)
	{
		$this->RegionID = $value;
	}
	/**
	 * @return SiteLocationType
	 */
	function getSiteLocation()
	{
		return $this->SiteLocation;
	}
	/**
	 * @return void
	 * @param SiteLocationType $value 
	 */
	function setSiteLocation($value)
	{
		$this->SiteLocation = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('SearchLocationType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'RegionID' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'SiteLocation' =>
					array(
						'required' => false,
						'type' => 'SiteLocationType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
