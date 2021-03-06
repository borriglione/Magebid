<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Mulitple bidders can be approved with one call. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/BidApprovalArrayType.html
 *
 */
class BidApprovalArrayType extends EbatNs_ComplexType
{

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('BidApprovalArrayType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__])) {
			self::$_elements[__CLASS__] = array();
		}
	}
}
?>
