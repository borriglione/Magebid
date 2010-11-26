<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * Specifies the seller's reason for ending an item listing early. Thisis required 
 * if the seller ended the listing early and the item didnot successfully sell of 
 * if the item has bids and the seller wants to sellto the high bidder. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/EndReasonCodeType.html
 *
 * @property string LostOrBroken
 * @property string NotAvailable
 * @property string Incorrect
 * @property string OtherListingError
 * @property string CustomCode
 * @property string SellToHighBidder
 * @property string Sold
 */
class EndReasonCodeType extends EbatNs_FacetType
{
	const CodeType_LostOrBroken = 'LostOrBroken';
	const CodeType_NotAvailable = 'NotAvailable';
	const CodeType_Incorrect = 'Incorrect';
	const CodeType_OtherListingError = 'OtherListingError';
	const CodeType_CustomCode = 'CustomCode';
	const CodeType_SellToHighBidder = 'SellToHighBidder';
	const CodeType_Sold = 'Sold';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('EndReasonCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_EndReasonCodeType = new EndReasonCodeType();

?>
