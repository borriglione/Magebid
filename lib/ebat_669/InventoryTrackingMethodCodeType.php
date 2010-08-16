<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * Defines options to track a listing by the eBay item ID or the seller's SKU.In 
 * some calls, elements of this type are only returned in the response whenthe 
 * value is set to SKU on the item. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/InventoryTrackingMethodCodeType.html
 *
 * @property string ItemID
 * @property string SKU
 * @property string CustomCode
 */
class InventoryTrackingMethodCodeType extends EbatNs_FacetType
{
	const CodeType_ItemID = 'ItemID';
	const CodeType_SKU = 'SKU';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('InventoryTrackingMethodCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_InventoryTrackingMethodCodeType = new InventoryTrackingMethodCodeType();

?>
