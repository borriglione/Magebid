<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
require_once 'EbatNs_FacetType.php';

/**
 *  
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/MessageStatusTypeCodeType.html
 *
 * @property string Answered
 * @property string Unanswered
 * @property string CustomCode
 */
class MessageStatusTypeCodeType extends EbatNs_FacetType
{
	const CodeType_Answered = 'Answered';
	const CodeType_Unanswered = 'Unanswered';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('MessageStatusTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_MessageStatusTypeCodeType = new MessageStatusTypeCodeType();

?>
