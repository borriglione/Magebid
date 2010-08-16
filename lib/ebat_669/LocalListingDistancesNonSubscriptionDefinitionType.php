<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Defines the LocalListingDistancesNonSubscription feature. This feature displays 
 * all the supported local listing distances for items listed by sellers who have 
 * not subscribed to either Local Market for Vehicles or Local Market for Specialty 
 * Vehicles. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/LocalListingDistancesNonSubscriptionDefinitionType.html
 *
 */
class LocalListingDistancesNonSubscriptionDefinitionType extends EbatNs_ComplexType
{

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('LocalListingDistancesNonSubscriptionDefinitionType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__])) {
			self::$_elements[__CLASS__] = array();
		}
	}
}
?>
