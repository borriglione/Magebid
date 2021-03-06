<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractResponseType.php';

/**
 * Returned after calling SellerReverseDisputeRequest. Contains the status of the 
 * call and any errors or warnings. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/SellerReverseDisputeResponseType.html
 *
 */
class SellerReverseDisputeResponseType extends AbstractResponseType
{

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('SellerReverseDisputeResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__])) {
			self::$_elements[__CLASS__] = array();
		}
	}
}
?>
