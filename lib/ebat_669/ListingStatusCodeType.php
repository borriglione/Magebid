<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * Specifies an active or ended listing's status in eBay's processingworkflow. If a 
 * listing ends with a sale (or sales), eBay needs toupdate the sale details (e.g., 
 * total price and buyer/high bidder)and the final value fee. This processing can 
 * take several minutes.If you retrieve a sold item and no details about the 
 * buyer/highbidder are returned or no final value fee is available, use 
 * thislisting status information to determine whether eBay has finishedprocessing 
 * the listing. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ListingStatusCodeType.html
 *
 * @property string Active
 * @property string Ended
 * @property string Completed
 * @property string CustomCode
 * @property string Custom
 */
class ListingStatusCodeType extends EbatNs_FacetType
{
	const CodeType_Active = 'Active';
	const CodeType_Ended = 'Ended';
	const CodeType_Completed = 'Completed';
	const CodeType_CustomCode = 'CustomCode';
	const CodeType_Custom = 'Custom';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ListingStatusCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ListingStatusCodeType = new ListingStatusCodeType();

?>
