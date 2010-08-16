<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 * This type contains the status of the items within a bid group. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/BidGroupItemStatusCodeType.html
 *
 * @property string CurrentBid
 * @property string Cancelled
 * @property string Pending
 * @property string Skipped
 * @property string Ended
 * @property string Won
 * @property string GroupClosed
 * @property string CustomCode
 */
class BidGroupItemStatusCodeType extends EbatNs_FacetType
{
	const CodeType_CurrentBid = 'CurrentBid';
	const CodeType_Cancelled = 'Cancelled';
	const CodeType_Pending = 'Pending';
	const CodeType_Skipped = 'Skipped';
	const CodeType_Ended = 'Ended';
	const CodeType_Won = 'Won';
	const CodeType_GroupClosed = 'GroupClosed';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('BidGroupItemStatusCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_BidGroupItemStatusCodeType = new BidGroupItemStatusCodeType();

?>
