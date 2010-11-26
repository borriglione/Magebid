<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractRequestType.php';

/**
 * Reports how many calls your application has made and is allowed to make perhour 
 * or day. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetApiAccessRulesRequestType.html
 *
 */
class GetApiAccessRulesRequestType extends AbstractRequestType
{

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetApiAccessRulesRequestType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__])) {
			self::$_elements[__CLASS__] = array();
		}
	}
}
?>
