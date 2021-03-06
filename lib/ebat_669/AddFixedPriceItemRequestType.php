<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'ItemType.php';
require_once 'AbstractRequestType.php';

/**
 * Defines and lists a new fixed-price item. A fixed-price listingcan include 
 * multiple identical items.<br><br>For the US, Canada (CA), French Canadian 
 * (CAFR), and US Motors sites, the FixedPriceItem listing formatwill be replacing 
 * the StoresFixedPrice listing format, and the StoresFixedPrice format will be 
 * deprecatedin early 2011. As of March 30, 2010, we will start a migration phase 
 * where AddItem and AddFixedPriceItemwill accept either FixedPriceItem or 
 * StoresFixedPrice as listing formats, but the item will be displayedas 
 * FixedPriceItem on the site and in search results. GetItem and other 'Get' calls 
 * will return the format you originallyused in the request. Therefore, the 
 * preferred format will be FixedPriceItem.<br><br>As part of the merge of the 
 * StoresFixedPrice and FixedPriceItem formats, the start price of all 
 * newFixedPriceItems must be 99 cents or greater. This change will also go into 
 * effect on March 30, 2010. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/AddFixedPriceItemRequestType.html
 *
 */
class AddFixedPriceItemRequestType extends AbstractRequestType
{
	/**
	 * @var ItemType
	 */
	protected $Item;

	/**
	 * @return ItemType
	 */
	function getItem()
	{
		return $this->Item;
	}
	/**
	 * @return void
	 * @param ItemType $value 
	 */
	function setItem($value)
	{
		$this->Item = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('AddFixedPriceItemRequestType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Item' =>
					array(
						'required' => false,
						'type' => 'ItemType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
